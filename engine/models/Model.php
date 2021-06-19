<?php

namespace app\models;

use app\interfaces\IModel;
use app\engine\Db;

abstract class Model implements IModel
{
    abstract protected function getTableName();

    protected int $rowsAffected = 0;

    public function getOne($id)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        return DB::getInstance()->queryOne($sql, ['id' => $id]);
    }

    public function getOneAsObject($id)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        return DB::getInstance()->queryOneObject($sql, ['id' => $id]);
    }

    public function getOneAsClass($id)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        return DB::getInstance()->queryOneClass($sql, ['id' => $id], get_called_class());
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->getTableName()}";
        return DB::getInstance()->queryAll($sql);
    }

    public function insert()
    {
        $fields = null;
        $values = null;
        $params = null;
        foreach ($this as $key => $value) {
            if ($value == null) continue;
            $fields .= "`{$key}`,";
            $values .= ":{$key},";
            $params[$key] = $value;
        }
        $fields = substr($fields, 0, -1);
        $values = substr($values, 0, -1);

        $sql = "INSERT INTO `{$this->getTableName()}` ({$fields}) VALUES ({$values})";

        $this->rowsAffected = DB::getInstance()->execute($sql, $params);
        $this->id = DB::getInstance()->lastInsertId();

        var_dump("Запись добавлена");
        return $this;
    }

    public function update()
    {
        $params = null;
        $id = $this->id;
        $obj = $this->getOneAsClass($id);
        //Не самый быстрый вариант, но пока работает
        foreach ($this as $key1 => $value1) {
            foreach ($obj as $key2 => $value2) {
                if ($key1 == $key2 && $value1 != $value2) {
                    $params[$key1] = $value1;
                }
            }
        }
        $sql = "UPDATE `{$this->getTableName()}` SET ";
        foreach ($params as $key => $value) {
            $sql .= "`{$key}` = :{$key}, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE `id` = :id";
        var_dump($sql);
        $params[':id'] = $id;
        $this->rowsAffected = DB::getInstance()->execute($sql, $params);

        var_dump("Запись изменена");
        return $this;
    }

    public function delete($id = null)
    {
        if (is_null($id)) {
            $id = $this->id;
        }
        $sql = "DELETE FROM `{$this->getTableName()}` WHERE `id` = {$id}";
        $this->rowsAffected = DB::getInstance()->execute($sql);

        var_dump("Запись удалена");
        return $this;
    }
}
