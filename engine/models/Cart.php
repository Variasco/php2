<?php


namespace app\models;


use app\engine\Db;

class Cart extends DBModel
{
    protected $props = [
        'id' => [
            'updated' => false,
            'value' => null
        ],
        'product_id' => [
            'updated' => false,
            'value' => null
        ],
        'quantity' => [
            'updated' => false,
            'value' => null
        ],
        'session_id' => [
            'updated' => false,
            'value' => null
        ],
    ];

    public function __construct($product_id = null, $quantity = null, $session_id = null)
    {
        $this->props['product_id']['value'] = $product_id;
        $this->props['quantity']['value'] = $quantity;
        $this->props['session_id']['value'] = $session_id;
    }

    public function getCart($session_id)
    {
        $sql = "SELECT `p`.`id` product_id, `c`.`id` cart_id, `p`.`name` name, `p`.`price` price, `c`.`quantity` quantity FROM 
            `products` p, `cart` c  WHERE `p`.`id` = `c`.`product_id` AND `c`.`session_id` = :session_id";
        return Db::getInstance()->queryAll($sql, ['session_id' => $session_id]);
    }

    public function getTotalPrice($session_id)
    {
        $sql = "SELECT SUM(`p`.`price`*`c`.`quantity`) `total` FROM `products` `p`, `cart` `c` 
            WHERE `p`.`id` = `c`.`product_id` AND `session_id` = :session_id";
        return Db::getInstance()->queryOne($sql, ['session_id' => $session_id])['total'];
    }

    protected function getTableName()
    {
        return 'cart';
    }
}
