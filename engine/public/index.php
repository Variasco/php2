<?php

use app\models\{Product, User, Order, Cart, Category};

include "../config/config.php";
include "../engine/Autoload.php";

spl_autoload_register([new Autoload(), 'loadClass']);

//Задание 4
$product = (new Product("Пицца","Описание", 125))->insert();
//$product->delete(); //Можно прокинуть id любой записи в таблице, сделал для своего удобства.

$product = (new Product())->getOneAsClass(1);
$product->price = 130; //было 125
$product->description = 'someText';
$product->update();

//Задание 5
var_dump((new Product())->getOneAsObject(1));
//или
var_dump((new Product())->getOneAsClass(1));
