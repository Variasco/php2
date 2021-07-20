<?php

namespace app\models\entities;


abstract class Model
{
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->props)) {
            $this->props[$name]['updated'] = true;
            $this->props[$name]['value'] = $value;
        } else {
            die("Ошибка. Затронуто несуществующее поле.");
        }
        return $this;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->props)) {
            return $this->props[$name]['value'];
        } else {
            die("Ошибка. Затронуто несуществующее поле.");
        }
    }
}
