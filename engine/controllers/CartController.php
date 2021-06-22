<?php


namespace app\controllers;

use app\models\Cart;
use app\models\Product;

class CartController extends MainController
{
    /** @var Cart $cart */
    protected function actionIndex() {
        $cart = (new Cart)->getAll();

        echo $this->render('cart', [
            'cart' => $cart
        ]);
    }
}
