<?php


namespace app\controllers;


use app\engine\Request;
use app\engine\Session;
use app\models\{Product, Cart};

class ApiController extends MainController
{
    protected function actionCatalog()
    {
        $request = $this->getRequest();
        if ($request->getParams()['page'] ?? false) {
            $page = $request->getParams()['page'];
            $catalog = (new Product())->getLimit($page);

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
            $cart = new Cart();
            $item = $cart->getWhere(['product_id', 'session_id'], [$body['id'], $session_id]);
            if ($item) {
                $item->quantity += 1;
                $item->save();
            } else {
                (new Cart($body['id'], 1, $session_id))->save();
            }
            $response['count'] = $cart->getCountWhere('session_id', $session_id);
            echo json_encode($response);
        } else {
            die('Пустое тело запроса');
        }
    }

    protected function actionDeleteFromCart()
    {
        $request = $this->getRequest();
        $body = $request->getParams() ?? null;

        if (!empty($body)) {
            $id = $body['id'];
            $session_id = $this->getSession()->getSessionId();
            $cart = new Cart();
            $item = $cart->getOneAsObject($id);
            if ($item->session_id == $session_id) {
                $item->delete();
            }
            $response['count'] = $cart->getCountWhere('session_id', $session_id);
            $response['total'] = $cart->getTotalPrice($session_id);
            echo json_encode($response);
        } else {
            die('Пустое тело запроса');
        }
    }

    protected function actionClearCart()
    {
        $session_id = $this->getSession()->getSessionId();
        $cart = new Cart();
        $cart->deleteWhere('session_id', $session_id);
        $response['count'] = $cart->getCountWhere('session_id', $session_id);
        echo json_encode($response);
    }
}
