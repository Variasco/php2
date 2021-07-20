<?php


namespace app\models\repositories;

use app\models\entities\Category;

class CategoryRepository extends Repository
{
    protected function getEntityClass()
    {
        return Category::class;
    }

    protected function getTableName()
    {
        return 'category';
    }
}
