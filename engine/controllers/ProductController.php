<?php

namespace app\controllers;

use app\models\Product;

class ProductController extends MainController
{
    protected function actionIndex() {
        $catalog = (new Product)->getAll();
        $page = $_GET['page'] ?? 0;

        echo $this->render('catalog', [
            'catalog' => $catalog,
            'page' => ++$page
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
