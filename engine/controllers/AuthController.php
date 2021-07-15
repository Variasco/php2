<?php


namespace app\controllers;

use app\engine\{App};
use app\exceptions\{AuthException};

class AuthController extends MainController
{
    protected function actionLogin()
    {
        $request = App::call()->request;
        $login = $request->getParams()['login'] ?? null;
        $pass = $request->getParams()['pass'] ?? null;
        $user = App::call()->userRepository;
        if ($user->auth($login, $pass)) {
            if ($request->getParams()['save'] ?? false) {
                $hash = uniqid(rand(), true);
                $id = App::call()->session->getParams()['id'] ?? null;
                if (!is_null($id)) {
                    $user->setCookie($id, $hash);
                    setcookie("hash", $hash, time() + 24 * 3600, "/");
                }
            }
            header("location: {$_SERVER['HTTP_REFERER']}");
            die();
        } else {
            throw new AuthException("Связка логин-пароль не существует");
        }
    }

    protected function actionLogout()
    {
        setcookie("hash", "", time() - 1, "/");
        App::call()->session->regenerateId();
        App::call()->session->destroy();
        header("location: {$_SERVER['HTTP_REFERER']}");
        die();
    }
}




