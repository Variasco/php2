<?php
session_start();

use app\engine\{Render, TwigRender};
use app\models\{Product, User, Order, Cart, Category};

include "../config/config.php";
include "../engine/Autoload.php";
include '../vendor/autoload.php';

spl_autoload_register([new Autoload(), 'loadClass']);

$controllerName = $_GET['c'] ?? 'index';
$actionName = $_GET['a'] ?? 'index';

$controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

if (class_exists($controllerClass)) {
    $controller = new $controllerClass(new TwigRender());
    $controller->runAction($actionName);
} else {
    echo "Контроллер не существует";
}


//CRUD реализованный функционал:

//INSERT
//$object = (new 'Model'(...props));
//$object->save();

//SELECT
//$assocArray = (new 'Model')->getAll();
//$assocArray = (new 'Model')->getLimit($from); //константа QUANTITY отвечает за количество элементов в выводе
//$assocArray = (new 'Model')->getOne($id);
//$object = (new 'Model')->getOneAsObject($id);

//UPDATE
//$object = (new 'Model')->getOneAsObject($id);
//$object->property = 'value';
//$object->save();

//DELETE
//$object = (new 'Model')->getOneAsObject($id);
//$object->delete();
