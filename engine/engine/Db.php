<?php

namespace app\engine;

use app\traits\TSingleton;

class Db
{
    protected $config = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'login' => 'root',
        'password' => 'root',
        'database' => 'shop',
        'charset' => 'utf8'
    ];

    use TSingleton;

    protected $connection = null;

    protected function getConnection()
    {
        if (is_null($this->connection)) {
            $this->connection = new \PDO($this->prepareDsnString(),
                $this->config['login'],
                $this->config['password']
            );
        }

        return $this->connection;
    }

    protected function prepareDsnString()
    {
        return sprintf("%s:host=%s;dbname=%s;charset=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset']
        );
    }

    public function lastInsertId()
    {
        return (int)$this->getConnection()->lastInsertId();
    }

    private function query($sql, $params)
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function queryLimit($sql, $params = []) {
        $stmt = $this->getConnection()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":{$key}", $value, \PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

//    public function queryOneObject($sql, $params)
//    {
//        return $this->query($sql, $params)->fetch(\PDO::FETCH_OBJ);
//    }

//    public function queryOneClass($sql, $params, $className)
//    {
//        $stmt = $this->query($sql, $params);
//        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $className);
//        return $stmt->fetch();
//    }

    public function queryOne($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch(\PDO::FETCH_ASSOC);
    }

    public function queryAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function executeSql($sql, $params = [])
    {
        return $this->query($sql, $params)->rowCount();
    }
}
