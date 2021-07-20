<?php


namespace app\models\repositories;

use app\engine\App;
use app\models\entities\User;

class UserRepository extends Repository
{
    public function getEntityClass()
    {
        return User::class;
    }

    public function getTableName()
    {
        return 'users';
    }

    public function isAuth()
    {
        $session = App::call()->session;
        $login = $session->getParams()['login'] ?? 'guest';
        if ($login != 'guest') {
            return true;
        }
        $hash = App::call()->request->getCookie()['hash'] ?? false;
        if ($hash) {
            $result = $this->getWhere('hash_cookie', $hash);
            if (!empty($result)) {
                $session->setParam('login', $result['login']);
                $session->setParam('id', $result['id']);
                return true;
            }
        }
        return false;
    }

    public function auth($login, $pass)
    {
        $result = $this->getWhere('login', $login);
        if (!empty($result)) {
            if (password_verify($pass, $result->hash_pass)) {
                $session = App::call()->session;
                $session->setParam('login', $login);
                $session->setParam('id', $result->id);
                $session->setParam('isAdmin', $result->is_admin);
                return true;
            }
        }
        return false;
    }

    public function setCookie($id, $hash)
    {
        $user = $this->getOneAsObject($id);
        $user->hash_cookie = $hash;
        $this->save($user);
    }

    public function getUser()
    {
        $login = App::call()->session->getParams()['login'] ?? 'guest';
        return $login;
    }

    public function isAdmin()
    {
        $isAdmin = App::call()->session->getParams()['isAdmin'] ?? 0;
        if ($isAdmin) {
            return true;
        }
        return false;
    }
}
