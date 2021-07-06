<?php


namespace app\controllers;

use app\models\Cart;
use app\models\Product;

class CartController extends MainController
{
    protected function actionIndex() {
        $session_id = $this->getSession()->getSessionId();
        $cart = (new Cart);
        $cartGoods = $cart->getCart($session_id);
        $total = $cart->getTotalPrice($session_id);

        echo $this->render('cart', [
            'cart' => $cartGoods,
            'total' => $total
        ]);
    }
}
