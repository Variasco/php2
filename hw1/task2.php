<?php

class Db
{
    protected $tableName;
    protected $wheres = [];


    public function table($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->tableName}";
        if (!empty($this->wheres)) {
            $sql .= " WHERE ";
            foreach ($this->wheres as $value) {
                $sql .= $value['field'] . " = " . $value['value'];
                if ($value != end($this->wheres)) $sql .= " AND ";
            }
            $this->wheres = [];
        }
        return $sql . "<br>";
    }

    public function getOne($id)
    {
        return "SELECT * FROM {$this->tableName} WHERE id = {$id}<br>";
    }

    public function where($field, $value)
    {
        $this->wheres[] = [
            'field' => $field,
            'value' => $value
        ];
        return $this;
    }

    public function andWhere($field, $value)
    {
        $this->where($field, $value);
        return $this;
    }
}

$db = new Db();
echo $db->table('goods')->getAll();
echo $db->table('goods')->getOne(1);
echo $db->table('user')->where('name', 'admin')->getAll();
echo $db->table('product')->where('name', 'Alex')->where('session', 123)->andWhere('id', 5)->getAll();
