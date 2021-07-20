<?php


namespace app\models\repositories;

use app\models\entities\Order;

class OrderRepository extends Repository
{
    public function getEntityClass()
    {
        return Order::class;
    }

    protected function getTableName()
    {
        return 'orders';
    }
}
