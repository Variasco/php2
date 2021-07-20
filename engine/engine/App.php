<?php


namespace app\engine;


use app\exceptions\RequestException;
use app\traits\TSingleton;
use app\models\repositories\{CartRepository, CategoryRepository, OrderRepository, ProductRepository, UserRepository};
use Exception;

/**
 * Class App
 * @property Request $request
 * @property CartRepository $cartRepository
 * @property UserRepository $userRepository
 * @property ProductRepository $productRepository
 * @property OrderRepository $orderRepository
 * @property CategoryRepository $categoryRepository
 * @property Session $session
 * @property Db $db
 */
class App
{
    use TSingleton;

    public $config;
    private $components;

    private $controller;
    private $action;

    public function runController() {
        $this->controller = $this->request->getControllerName() ?: 'index';
        $this->action = $this->request->getActionName() ?? 'index';

        $controllerClass = $this->config['controllers_namespaces'] . ucfirst($this->controller) . "Controller";

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass(new Render());
            $controller->runAction($this->action);
        } else {
            throw new RequestException("Контроллер не существует");
        }
    }

    public static function call()
    {
        return static::getInstance();
    }

    public function run($config)
    {
        $this->config = $config;
        $this->components = new Storage();
        $this->runController();
    }

    public function createComponent($name) {
        if (isset($this->config['components'][$name])) {
            $params = $this->config['components'][$name];
            $class = $params['class'];
            if (class_exists($class)) {
                unset($params['class']);
                $reflection = new \ReflectionClass($class);
                return $reflection->newInstanceArgs($params);//new $class($params)
            } else {
                throw new Exception("Класс {$class} не найден");
            }
        } else {
            throw new Exception("Компонент {$this->config['components'][$name]} не найден");
        }
    }

    public function __get($name)
    {
        return $this->components->get($name);
    }
}
