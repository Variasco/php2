<?php


namespace app\controllers;

use app\engine\{App};
use app\exceptions\{ApiException};
use app\models\entities\{Cart};
use app\models\repositories\{CartRepository, ProductRepository};

class ApiController extends MainController
{
    protected function actionCatalog()
    {
        $request = App::call()->request;
        if ($request->getParams()['page'] ?? false) {
            $page = $request->getParams()['page'];
            $catalog = App::call()->productRepository->getLimit($page);

            empty($catalog) ? $response[0] = false : $response[0] = true;

            $response[1] = $this->renderTemplate('catalogMore', [
                'catalog' => $catalog,
            ]);

            $response[2] = $page + App::call()->config['quantity'];
            echo json_encode($response);
        }
    }

    protected function actionAddToCart()
    {
        $request = App::call()->request;
        $body = $request->getParams() ?? null;
        if (!empty($body)) {
            $session_id = App::call()->session->getSessionId();
            $cart = App::call()->cartRepository;
            $item = $cart->getWhere(['product_id', 'session_id'], [$body['id'], $session_id]);
            if ($item) {
                $item->quantity += 1;
                $cart->save($item);
            } else {
                App::call()->cartRepository->save(new Cart($body['id'], 1, $session_id));
            }
            $response['count'] = $cart->getCountWhere('session_id', $session_id);
            echo json_encode($response);
        } else {
            throw new ApiException('Пустое тело запроса');
        }
    }

    protected function actionDeleteFromCart()
    {
        $request = App::call()->request;
        $body = $request->getParams() ?? null;

        if (!empty($body)) {
            $id = $body['id'];
            if (isset($body['order_id'])) {
                $order_id = $body['order_id'] ?? null;
                $session_id = App::call()->orderRepository->getOne($order_id)['session_id'];
            } else {
                $session_id = App::call()->session->getSessionId();
            }
            $cart = App::call()->cartRepository;
            $item = $cart->getOneAsObject($id);
            if ($item->session_id == $session_id) {
                $cart->delete($item);
            }
            $response['count'] = $cart->getCountWhere('session_id', $session_id);
            $response['total'] = $cart->getTotalPrice($session_id);
            echo json_encode($response);
        } else {
            throw new ApiException('Пустое тело запроса');
        }
    }

    protected function actionClearCart()
    {
        $session_id = App::call()->session->getSessionId();
        $cart = App::call()->cartRepository;
        $cart->deleteWhere('session_id', $session_id);
        $response['count'] = $cart->getCountWhere('session_id', $session_id);
        echo json_encode($response);
    }
}
