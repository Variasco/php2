<?php


namespace app\models;


class Order extends DBModel
{
    public $id;
    public $name;
    public $phone;
    public $status;
    public $session_id;
    public $created_at;

    protected function getTableName()
    {
        return 'orders';
    }
}
