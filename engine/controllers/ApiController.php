<?php


namespace app\controllers;


use app\engine\Request;
use app\models\{Product, Cart};

class ApiController extends MainController
{
    private $request;

    private function getRequest() {
        if (is_null($this->request)) {
            $this->request = new Request();
        }
        return $this->request;
    }

    protected function actionCatalog() {
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

    protected function actionAddToCart() {
        $request = $this->getRequest();
        $body = $request->getParams() ?? null;
        if(!empty($body)) {
            $session_id = session_id();
            (new Cart($body['id'], 1, $session_id))->save();
            $response['count'] = (new Cart())->getCountWhere('session_id', $session_id);
            echo json_encode($response);
        } else {
            die('Пустое тело запроса');
        }
    }

    protected function actionDeleteFromCart() {
        $request = $this->getRequest();
        $body = $request->getParams() ?? null;

        if (!empty($body)) {
            $id = $body['id'];
            $session_id = session_id();
            $cart = new Cart();
            $cart->getOneAsObject($id)->delete();
            $response['count'] = $cart->getCountWhere('session_id', $session_id);
            $response['total'] = $cart->getTotalPrice($session_id);
            echo json_encode($response);
        } else {
            die('Пустое тело запроса');
        }
    }
}
