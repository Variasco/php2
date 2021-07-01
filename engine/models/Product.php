<?php


namespace app\models;


class Product extends DBModel
{
    protected $props = [
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

    public function __construct($name = null, $description = null, $price = null, $picture = null, $category_id = null)
    {
        $this->props['name']['value'] = $name;
        $this->props['price']['value'] = $price;
        $this->props['description']['value'] = $description;
        $this->props['picture']['value'] = $picture;
        $this->props['category_id']['value'] = $category_id;
    }

    protected function getTableName()
    {
        return 'products';
    }
}
