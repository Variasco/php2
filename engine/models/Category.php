<?php


namespace app\models;


class Category extends Model
{
    public $id;
    public $name;


    protected function getTableName()
    {
        return 'category';
    }
}
