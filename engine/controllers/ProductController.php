<?php

namespace app\controllers;

use app\engine\Request;
use app\models\Product;

class ProductController extends MainController
{
    protected function actionIndex() {
        $request = new Request();
        $page = $request->getParams()['page'] ?? QUANTITY;
        $catalog = (new Product)->getLimit();

        echo $this->render('catalog', [
            'catalog' => $catalog,
            'page' => $page,
            'uniqid' => uniqid()
        ]);
    }

    protected function actionCard() {
        $id = $_GET['id'];
        $good = (new Product)->getOne($id);
        echo $this->render('card', [
            'good' => $good
        ]);
    }
}
