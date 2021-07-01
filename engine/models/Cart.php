<?php


namespace app\models;


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


    protected function getTableName()
    {
        return 'cart';
    }
}
