<?php


namespace app\models\entities;


class Order extends Model
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
        'phone' => [
            'updated' => false,
            'value' => null
        ],
        'status' => [
            'updated' => false,
            'value' => null
        ],
        'session_id' => [
            'updated' => false,
            'value' => null
        ],
        'created_at' => [
            'updated' => false,
            'value' => null
        ],
    ];

    public function __construct($name = null, $phone = null, $session_id = null, $status = null, $created_at = null)
    {
        $this->props['name']['value'] = $name;
        $this->props['phone']['value'] = $phone;
        $this->props['status']['value'] = $status;
        $this->props['session_id']['value'] = $session_id;
        $this->props['created_at']['value'] = $created_at;
    }
}
