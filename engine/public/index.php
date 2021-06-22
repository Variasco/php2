<?php

use app\models\{Product, User, Order, Cart, Category};

include "../config/config.php";
include "../engine/Autoload.php";

spl_autoload_register([new Autoload(), 'loadClass']);

$controllerName = $_GET['c'] ?? 'index';
$actionName = $_GET['a'] ?? 'index';

$controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    $controller->runAction($actionName);
} else {
    echo "404";
}

if ($_GET['page'] ?? false) {
    $str = 'we are happy';
    echo json_encode($str);
}
