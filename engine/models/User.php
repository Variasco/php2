<?php

namespace app\models;

class User extends DBModel
{
//    protected $id;
//    protected $login;
//    protected $hash_pass;
//    protected $is_admin;
//    protected $hash_cookie;

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

    public function __construct($login = null, $hash_pass = null, $is_admin = null)
    {
        $this->props['login']['value'] = $login;
        $this->props['hash_pass']['value'] = $hash_pass;
        $this->props['is_admin']['value'] = $is_admin;
    }

    public function getTableName()
    {
        return 'users';
    }


}
