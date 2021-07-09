<?php


namespace app\models\repositories;

use app\models\entities\Order;

class OrderRepository extends Repository
{
    protected function getEntityClass()
    {
        return Order::class;
    }

    protected function getTableName()
    {
        return 'orders';
    }
}
