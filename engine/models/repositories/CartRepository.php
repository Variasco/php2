<?php


namespace app\models\repositories;


use app\engine\Db;
use app\models\entities\Cart;

class CartRepository extends Repository
{
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

    public function getQuantity($product_id, $session_id) {
        $sql = "SELECT `quantity` FROM `cart` WHERE `product_id` = :product_id AND `session_id` = :session_id";
        return Db::getInstance()->queryOne($sql, ['product_id' => $product_id, 'session_id' => $session_id]);
    }

    protected function getEntityClass()
    {
        return Cart::class;
    }

    protected function getTableName()
    {
        return 'cart';
    }
}
