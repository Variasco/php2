<?php


namespace app\controllers;


use app\engine\Request;
use app\models\User;

class AuthController extends MainController
{
    protected function actionLogin()
    {
        $login = $this->getRequest()->getParams()['login'] ?? null;
        $pass = $this->getRequest()->getParams()['pass'] ?? null;
        $user = new User();
        if ($user->auth($login, $pass)) {
            if ($this->getRequest()->getParams()['save'] ?? false) {
                $hash = uniqid(rand(), true);
                $id = $this->getSession()->getParams()['id'] ?? null;
                if (!is_null($id)) {
                    $user->setCookie($id, $hash);
                    setcookie("hash", $hash, time() + 24 * 3600, "/");
                }
            }
            header("location: {$_SERVER['HTTP_REFERER']}");
            die();
        } else {
            die("Связка логин-пароль не существует");
        }
    }

    protected function actionLogout()
    {
        setcookie("hash", "", time() - 1, "/");
        session_regenerate_id();
        session_destroy();
        header("location: {$_SERVER['HTTP_REFERER']}");
        die();
    }
}




