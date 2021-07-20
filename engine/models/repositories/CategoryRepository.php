<?php


namespace app\models\repositories;

use app\models\entities\Category;

class CategoryRepository extends Repository
{
    public function getEntityClass()
    {
        return Category::class;
    }

    protected function getTableName()
    {
        return 'category';
    }
}
