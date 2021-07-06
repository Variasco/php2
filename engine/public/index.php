<?php
session_start();

use app\engine\{Render, Request, Session, TwigRender};
use app\models\{Product, User, Order, Cart, Category};

include "../config/config.php";
include "../engine/Autoload.php";
include '../vendor/autoload.php';

spl_autoload_register([new Autoload(), 'loadClass']);

$request = new Request;

$controllerName = $request->getControllerName() ?: 'index';
$actionName = $request->getActionName() ?? 'index';

$controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

if (class_exists($controllerClass)) {
    $controller = new $controllerClass(new Render());
    $controller->runAction($actionName);
} else {
    echo "Контроллер не существует";
}
