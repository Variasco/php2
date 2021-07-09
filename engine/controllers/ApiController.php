<?php


namespace app\controllers;

use app\exceptions\ApiException;
use app\models\entities\Cart;
use app\models\repositories\{CartRepository, ProductRepository};

class ApiController extends MainController
{
    protected function actionCatalog()
    {
        $request = $this->getRequest();
        if ($request->getParams()['page'] ?? false) {
            $page = $request->getParams()['page'];
            $catalog = (new ProductRepository())->getLimit($page);

            $response[] = $this->renderTemplate('catalogMore', [
                'catalog' => $catalog,
            ]);
            $response[] = $page + QUANTITY;
            echo json_encode($response);
        }
    }

    protected function actionAddToCart()
    {
        $request = $this->getRequest();
        $body = $request->getParams() ?? null;
        if (!empty($body)) {
            $session_id = $this->getSession()->getSessionId();
            $cart = new CartRepository();
            $item = $cart->getWhere(['product_id', 'session_id'], [$body['id'], $session_id]);
            if ($item) {
                $item->quantity += 1;
                $cart->save($item);
            } else {
                (new CartRepository())->save(new Cart($body['id'], 1, $session_id));
            }
            $response['count'] = $cart->getCountWhere('session_id', $session_id);
            echo json_encode($response);
        } else {
            throw new ApiException('Пустое тело запроса');
        }
    }

    protected function actionDeleteFromCart()
    {
        $request = $this->getRequest();
        $body = $request->getParams() ?? null;

        if (!empty($body)) {
            $id = $body['id'];
            $session_id = $this->getSession()->getSessionId();
            $cart = new CartRepository();
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
        $session_id = $this->getSession()->getSessionId();
        $cart = new CartRepository();
        $cart->deleteWhere('session_id', $session_id);
        $response['count'] = $cart->getCountWhere('session_id', $session_id);
        echo json_encode($response);
    }
}
