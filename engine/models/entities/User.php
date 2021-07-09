<?php

namespace app\models\entities;


class User extends Model
{
    public $props = [
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
}
