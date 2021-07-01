<?php


namespace app\controllers;


use app\models\User;

class AuthController extends MainController
{
    protected function actionLogin()
    {
        $login = $_POST['login'] ?? null;
        $pass = $_POST['pass'] ?? null;
        if (User::auth($login, $pass)) {
            if (isset($_POST['save'])) {
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




