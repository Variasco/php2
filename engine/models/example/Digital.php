<?php


namespace app\models\example;


class Digital extends Product
{
    public function calcPrice()
    {
        $this->total += $this->price * $this->quantity / 2;
    }
}