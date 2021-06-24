<?php


namespace app\models;


class Product extends DBModel
{
//    protected $id;
//    public $name;
//    public $price;
//    public $description;
//    public $picture;
//    protected $category_id;

    public $props = [
        'id' => [
            'updated' => false,
            'value' => null
        ],
        'name' => [
            'updated' => false,
            'value' => null
        ],
        'price' => [
            'updated' => false,
            'value' => null
        ],
        'description' => [
            'updated' => false,
            'value' => null
        ],
        'picture' => [
            'updated' => false,
            'value' => null
        ],
        'category_id' => [
            'updated' => false,
            'value' => null
        ],
    ];

    public function __construct($name = null, $description = null, $price = null)
    {
        $this->props['name']['value'] = $name;
        $this->props['price']['value'] = $price;
        $this->props['description']['value'] = $description;
    }

    protected function getTableName()
    {
        return 'products';
    }
}
