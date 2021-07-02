<?php

namespace app\models;

use app\engine\Request;
use app\engine\Session;
use app\interfaces\IModel;

abstract class Model implements IModel
{
    private $request;
    private $session;

    protected function getRequest() {
        if (is_null($this->request)) {
            $this->request = new Request();
        }
        return $this->request;
    }

    protected function getSession() {
        if (is_null($this->session)) {
            $this->session = new Session();
        }
        return $this->session;
    }

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
