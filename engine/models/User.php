<?php

namespace app\models;

class User extends DBModel
{
    protected $props = [
        'id' => [
            'updated' => false,
            'value' => null
        ],
        'login' => [
            'updated' => false,
            'value' => null
        ],
        'hash_pass' => [
            'updated' => false,
            'value' => null
        ],
        'is_admin' => [
            'updated' => false,
            'value' => null
        ],
        'hash_cookie' => [
            'updated' => false,
            'value' => null
        ],
    ];

    public function __construct($login = null, $hash_pass = null, $is_admin = null, $hash_cookie = null)
    {
        $this->props['login']['value'] = $login;
        $this->props['hash_pass']['value'] = $hash_pass;
        $this->props['is_admin']['value'] = $is_admin;
        $this->props['hash_cookie']['value'] = $hash_cookie;
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
            $result = (new User)->getWhere('hash_cookie', $hash);
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
        $result = (new User)->getWhere('login', $login);
        if (!empty($result)) {
            if (password_verify($pass, $result['hash_pass'])) {
                $this->getSession()->setParam('login', $login);
                $this->getSession()->setParam('id', $result['id']);
                $this->getSession()->setParam('isAdmin', $result['is_admin']);
                return true;
            }
        }
        return false;
    }

    public function setCookie($id, $hash)
    {
        $user = (new User)->getOneAsObject($id);
        $user->hash_cookie = $hash;
        $user->save();
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
