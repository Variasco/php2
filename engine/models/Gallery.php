<?php


namespace app\models;


class Gallery extends Model
{
    public $id;
    public $name;
    public $views;

    protected function getTableName()
    {
        return 'gallery';
    }
}