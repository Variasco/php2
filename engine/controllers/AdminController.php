<?php


namespace app\controllers;


class AdminController extends MainController
{
    protected function actionIndex()
    {
        echo $this->render('admin');
    }
}
