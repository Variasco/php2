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

//Примеры CRUD:
//INSERT
//$user = (new User("vari", "123"));
//var_dump($user);
//$user->save();

//UPDATE
//$user = (new User)->getOneAsObject(1);
//var_dump($user);
//$user->login = "adminchik";
//$user->save();
//var_dump($user);



//CRUD реализованный функционал:

//INSERT
//$object = (new 'Model'(...props));
//$object->save();

//SELECT
//$assocArray = (new 'Model')->getAll();
//$assocArray = (new 'Model')->getLimit($from); //константа QUANTITY отвечает за количество элементов в выводе
//$assocArray = (new 'Model')->getOne($id);
//$object = (new 'Model')->getOneAsObject($id)

//UPDATE
//$object = (new 'Model')->getOneAsObject($id);
//$object->property = 'value';
//$object->save();

//DELETE
//$object = (new 'Model')->getOneAsObject($id);
//$object->delete();
