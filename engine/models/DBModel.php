<?php


namespace app\models;

use app\engine\Db;

abstract class DBModel extends Model
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
        $array = DB::getInstance()->queryOne($sql, ['id' => $id]);
        $class = get_called_class();
        $obj = new $class;
        foreach ($array as $key => $value) {
            $obj->props["{$key}"]['value'] = $value;
            $obj->props["{$key}"]['updated'] = false;
        }
        return $obj;
    }

//    public function getOneAsClass($id)
//    {
//        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
//        return DB::getInstance()->queryOneClass($sql, ['id' => $id], get_called_class());
//    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->getTableName()}";
        return DB::getInstance()->queryAll($sql);
    }

    public function getLimit($page = 0)
    {
        $params = [
            'from' => $page,
            'quantity' => QUANTITY,
        ];
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM `{$tableName}`  LIMIT :from, :quantity";
        //SELECT * FROM `product` LIMIT 2, 2
        return DB::getInstance()->queryLimit($sql, $params);
    }

    protected function insert()
    {
        $fields = null;
        $values = null;
        $params = null;
        $tableName = $this->getTableName();
        foreach ($this->props as $key => $value) {
            if (is_null($value['value'])) continue;
            $params[$key] = $value['value'];
            $fields .= "`{$key}`, ";
            $values .= ":{$key}, ";
        }
        var_dump($params);

        $fields = substr($fields, 0, -2);
        $values = substr($values, 0, -2);

        $sql = "INSERT INTO `{$tableName}` ({$fields}) VALUES ({$values})";
        var_dump($sql);

        $this->rowsAffected = DB::getInstance()->executeSql($sql, $params);
        $this->props['id']['value'] = DB::getInstance()->lastInsertId();

        echo "Запись добавлена. Количество затронутых строк: {$this->rowsAffected}";
        $this->rowsAffected = 0;
        return $this;
    }

    protected function update()
    {
        $params["id"] = $this->props['id']['value'];
        $tableName = $this->getTableName();
        $sql = "UPDATE `{$tableName}` SET ";
        foreach ($this->props as $key => $value) {
            if (!$value['updated']) continue;
            $params["{$key}"] = $value['value'];
            $sql .= "`{$key}` = :{$key}, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE `id` = :id";
        var_dump($params, $sql);

        $this->rowsAffected = DB::getInstance()->executeSql($sql, $params);

        echo "Запись изменена. Количество затронутых строк: {$this->rowsAffected}";
        $this->rowsAffected = 0;
        return $this;
    }

    public function delete()
    {
        $params['id'] = $this->props['id']['value'];
        $tableName = $this->getTableName();
        $sql = "DELETE FROM `{$tableName}` WHERE `id` = :id";
        var_dump($sql);

        $this->rowsAffected = DB::getInstance()->executeSql($sql, $params);

        echo "Запись удалена. Количество затронутых строк: {$this->rowsAffected}";
        $this->rowsAffected = 0;
        return $this;
    }

    public function save()
    {
        if (is_null($this->props['id']['value'])) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }
}