<?php


namespace app\controllers;


use app\engine\Request;
use app\models\User;

class AuthController extends MainController
{
    protected function actionLogin()
    {
        $request = new Request();
        $login = $request->getParams()['login'] ?? null;
        $pass = $request->getParams()['pass'] ?? null;
        if (User::auth($login, $pass)) {
            if ($request->getParams()['save'] ?? false) {
                $hash = uniqid(rand(), true);
                User::setCookie($_SESSION['id'], $hash);
                setcookie("hash", $hash, time() + 24 * 3600, "/");
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




