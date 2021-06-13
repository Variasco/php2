<?php


namespace app\models\example;


class Weight extends Product
{
    public function calcPrice()
    {
        $this->total += $this->price * $this->quantity * 0.9;
    }
}