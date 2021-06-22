<?php


namespace app\controllers;


class IndexController extends MainController
{
    protected function actionIndex() {
        echo $this->render('index');
    }
}
