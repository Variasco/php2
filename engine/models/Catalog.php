<?php

namespace app\models;

class Catalog extends Model
{
    public $id;
    public $name;
    public $picture;
    public $description;
    public $price;


    protected function getTableName()
    {
        return 'catalog';
    }


}

