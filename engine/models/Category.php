<?php


namespace app\models;


class Category extends DBModel
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
    ];

    public function __construct($name = null)
    {
        $this->props['name']['value'] = $name;
    }

    protected function getTableName()
    {
        return 'category';
    }
}
