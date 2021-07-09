<?php


namespace app\models\repositories;

use app\models\entities\Model;
use app\engine\{Request, Session, Db};

abstract class Repository
{
    abstract protected function getTableName();
    abstract protected function getEntityClass();

    protected int $rowsAffected = 0;

    private $request;
    private $session;

    protected function getRequest()
    {
        if (is_null($this->request)) {
            $this->request = new Request();
        }
        return $this->request;
    }

    protected function getSession()
    {
        if (is_null($this->session)) {
            $this->session = new Session();
        }
        return $this->session;
    }

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return DB::getInstance()->queryOne($sql, ['id' => $id]);
    }

    public function getOneAsObject($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        $class = $this->getEntityClass();
        // $obj2 = DB::getInstance()->queryOneClass($sql, ['id' => $id] ,$class);
        // Если сделать так, и заполнить объект через магический set, то всем полям 'updated' выставится true
        $array = DB::getInstance()->queryOne($sql, ['id' => $id]);

        $obj = new $class;
        foreach ($array as $key => $value) {
            $obj->props[$key]['value'] = $value;
        }

        return $obj;
    }

    public function getOneAsClass($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return DB::getInstance()->queryOneClass($sql, ['id' => $id], $this->getEntityClass());
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return DB::getInstance()->queryAll($sql);
    }

    public function getLimit($page = 0)
    {
        $params = [
            'from' => $page,
            'quantity' => QUANTITY,
        ];
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM `{$tableName}` LIMIT :from, :quantity";
        return DB::getInstance()->queryLimit($sql, $params);
    }

    public function getWhere(array|string $fields, array|string $values)
    {
        $tableName = $this->getTableName();
        $class = $this->getEntityClass();

        if (is_array($fields) and is_array($values)) {
            $params = array_combine($fields, $values);
            $sql = "SELECT * FROM `{$tableName}` WHERE ";
            foreach ($params as $key => $value) {
                $sql .= "`{$key}` = :{$key} AND ";
            }
            $sql = substr($sql, 0, -5);
            return DB::getInstance()->queryOneClass($sql, $params, $class);
        }
        elseif (!is_array($fields) and !is_array($values)) {
            $sql = "SELECT * FROM `{$tableName}` WHERE `{$fields}` = :value";
            return DB::getInstance()->queryOneClass($sql, ['value' => $values], $class);

        } else {
            throw new \Exception("Неподходящие входные данные метода getWhere");
        }
    }

    public function getCountWhere($field, $value)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT count(id) count FROM `{$tableName}` WHERE `{$field}` = :value";
        return Db::getInstance()->queryOne($sql, ['value' => $value])['count'];
    }

    protected function insert(Model $entity)
    {
        $fields = '';
        $values = '';
        $params = [];
        $tableName = $this->getTableName();
        foreach ($entity->props as $key => $value) {
            if (is_null($value['value'])) continue;
            $params[$key] = $value['value'];
            $fields .= "`{$key}`, ";
            $values .= ":{$key}, ";
        }

        $fields = substr($fields, 0, -2);
        $values = substr($values, 0, -2);

        $sql = "INSERT INTO `{$tableName}` ({$fields}) VALUES ({$values})";

        $this->rowsAffected = DB::getInstance()->executeSql($sql, $params);
        $entity->props['id']['value'] = DB::getInstance()->lastInsertId();

//        echo "Запись добавлена. Количество затронутых строк: {$this->rowsAffected}";
        return $this->rowsAffected;
    }

    protected function update(Model $entity)
    {
        $params["id"] = $entity->id;
        $tableName = $this->getTableName();
        $sql = "UPDATE `{$tableName}` SET ";
        foreach ($entity->props as $key => $value) {
            if (!$value['updated']) continue;
            $params["{$key}"] = $value['value'];
            $sql .= "`{$key}` = :{$key}, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE `id` = :id";

        $this->rowsAffected = DB::getInstance()->executeSql($sql, $params);

//        echo "Запись изменена. Количество затронутых строк: {$this->rowsAffected}";
        return $this->rowsAffected;
    }

    public function delete(Model $entity)
    {
        $params['id'] = $entity->id;
        $tableName = $this->getTableName();
        $sql = "DELETE FROM `{$tableName}` WHERE `id` = :id";

        $this->rowsAffected = DB::getInstance()->executeSql($sql, $params);

//        echo "Запись удалена. Количество затронутых строк: {$this->rowsAffected}";
        return $this->rowsAffected;
    }

    public function deleteWhere($field, $value)
    {
        $tableName = $this->getTableName();
        $sql = "DELETE FROM `{$tableName}` WHERE `{$field}` = :value";
        $this->rowsAffected = DB::getInstance()->executeSql($sql, ['value' => $value]);

//        echo "Записи удалены. Количество затронутых строк: {$this->rowsAffected}";
        return $this->rowsAffected;
    }

    public function save(Model $entity)
    {
        if (is_null($entity->id)) {
            return $this->insert($entity);
        } else {
            return $this->update($entity);
        }
    }
}
