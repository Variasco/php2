<?php

namespace app\models;

class User extends Model
{
    public $id;
    public $login;
    public $hash_pass;
    public $is_admin;
    public $hash_cookie;

    public function getTableName()
    {
        return 'users';
    }


}
