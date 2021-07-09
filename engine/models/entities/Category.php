<?php


namespace app\models\entities;


class Category extends Model
{
    public $props = [
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
}
