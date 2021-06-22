<?php


namespace app\models;


class Product extends DBModel
{
    public $id;
    public $name;
    public $price;
    public $description;
    public $picture;
    public $category_id;

    public function __construct($name = null, $description = null, $price = null)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }

    protected function getTableName()
    {
        return 'products';
    }
}
