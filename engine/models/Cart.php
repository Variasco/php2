<?php


namespace app\models;


class Cart extends DBModel
{
    public $id;
    public $product_id;
    public $quantity;
    public $session_id;

    protected function getTableName()
    {
        return 'cart';
    }
}
