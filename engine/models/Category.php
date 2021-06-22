<?php


namespace app\models;


class Category extends DBModel
{
    public $id;
    public $name;


    protected function getTableName()
    {
        return 'category';
    }
}
