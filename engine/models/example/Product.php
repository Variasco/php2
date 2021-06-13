<?php


namespace app\models\example;


abstract class Product
{
    public $id;
    public $name;
    public $price;
    public $quantity;
    public $total = 0;

    public function __construct($quantity, $price)
    {
        $this->quantity = $quantity;
        $this->price = $price;
    }

    abstract public function calcPrice();
}