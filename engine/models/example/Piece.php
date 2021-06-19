<?php


namespace app\models\example;


class Piece extends Product
{
    public function calcPrice()
    {
        $this->total += $this->price * $this->quantity;
    }
}