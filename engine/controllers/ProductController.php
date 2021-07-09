<?php

namespace app\controllers;

use app\engine\Request;
use app\models\repositories\ProductRepository;

class ProductController extends MainController
{
    protected function actionIndex() {
        $request = $this->getRequest();
        $page = $request->getParams()['page'] ?? QUANTITY;
        $catalog = (new ProductRepository())->getLimit();

        echo $this->render('catalog', [
            'catalog' => $catalog,
            'page' => $page,
            'uniqid' => uniqid()
        ]);
    }

    protected function actionCard() {
        $request = $this->getRequest();
        $id = $request->getParams()['id'];
        $good = (new ProductRepository)->getOne($id);
        echo $this->render('card', [
            'good' => $good
        ]);
    }
}
