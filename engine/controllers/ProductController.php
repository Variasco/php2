<?php

namespace app\controllers;

use app\engine\{App, Request};

class ProductController extends MainController
{
    protected function actionIndex() {
        $page = App::call()->request->getParams()['page'] ?? App::call()->config['quantity'];
        $catalog = App::call()->productRepository->getLimit();

        echo $this->render('catalog', [
            'catalog' => $catalog,
            'page' => $page,
            'uniqid' => uniqid()
        ]);
    }

    protected function actionCard() {
        $id = App::call()->request->getParams()['id'];
        $good = App::call()->productRepository->getOne($id);
        echo $this->render('card', [
            'good' => $good
        ]);
    }
}
