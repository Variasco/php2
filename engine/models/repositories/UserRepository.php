<?php


namespace app\models\repositories;

use app\models\entities\User;

class UserRepository extends Repository
{
    protected function getEntityClass()
    {
        return User::class;
    }

    public function getTableName()
    {
        return 'users';
    }

    public function isAuth()
    {
        $session = $this->getSession();
        $login = $session->getParams()['login'] ?? 'guest';
        if ($login != 'guest') {
            return true;
        }
        $hash = $this->getRequest()->getCookie()['hash'] ?? false;
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
                $session = $this->getSession();
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
        $login = $this->getSession()->getParams()['login'] ?? 'guest';
        if ($login != 'guest') {
            return $login;
        }
        return 'guest';
    }

    public function isAdmin()
    {
        $isAdmin = $this->getSession()->getParams()['isAdmin'] ?? 0;
        if ($isAdmin) {
            return true;
        }
        return false;
    }
}
