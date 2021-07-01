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

    public static function isAuth()
    {
        $login = User::getUser();
        if ($login != 'guest') {
            return true;
        }
        if (isset($_COOKIE['hash'])) {
            $hash_cookie = $_COOKIE['hash'];
            $result = (new User)->getWhere('hash_cookie', $hash_cookie);
            if (!empty($result)) {
                $_SESSION['login'] = $result['login'];
                $_SESSION['id'] = $result['id'];
                return true;
            }
        }
        return false;
    }

    public static function auth($login, $pass)
    {
        $result = (new User)->getWhere('login', $login);
        if (!empty($result)) {
            if (password_verify($pass, $result['hash_pass'])) {
                $_SESSION['login'] = $login;
                $_SESSION['id'] = $result['id'];
                $_SESSION['isAdmin'] = $result['is_admin'];
                return true;
            }
        }
        return false;
    }

    public static function setCookie($id, $hash)
    {
        $user = (new User)->getOneAsObject($id);
        $user->hash_cookie = $hash;
        $user->save();
    }

    public static function getUser()
    {
        if (isset($_SESSION['login'])) {
            return $_SESSION['login'];
        }
        return 'guest';
    }

    public static function isAdmin()
    {
        if ($_SESSION['isAdmin'] ?? false) {
            return true;
        }
        return false;
    }
}
