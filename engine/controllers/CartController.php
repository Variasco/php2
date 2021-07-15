<?php


namespace app\controllers;

use app\engine\App;
use app\models\entities\{Order};

class CartController extends MainController
{
    protected function actionIndex()
    {
        $session_id = App::call()->session->getSessionId();
        $cart = App::call()->cartRepository;
        $cartGoods = $cart->getCart($session_id);
        $total = $cart->getTotalPrice($session_id);

        echo $this->render('cart', [
            'cart' => $cartGoods,
            'total' => $total,
            'message' => App::call()->session->getParams()['message'] ?? null
        ]);

        App::call()->session->setParam('message', null);
    }

    protected function actionOrder()
    {
        $session_id = App::call()->session->getSessionId();
        $name = App::call()->request->getParams()['name'];
        $phone = App::call()->request->getParams()['phone'];
        $order = new Order($name, $phone, $session_id);
        App::call()->orderRepository->save($order);
        App::call()->session->regenerateId();
        App::call()->session->setParam('message', 'Заказ оформлен');
        header("location: {$_SERVER['HTTP_REFERER']}");
        die();
    }
}
