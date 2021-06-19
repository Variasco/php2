<?php

use app\models\{Catalog, User, Order, Gallery, Cart};
use app\models\example\{Product, Piece, Digital, Weight};
use app\engine\Db;

include "../engine/Autoload.php";

spl_autoload_register([new Autoload(), 'loadClass']);

$good1 = new Piece(2, 150);
$good2 = new Digital(3, 100);
$good3 = new Weight(4, 20);

$good1->calcPrice();
$good2->calcPrice();
$good3->calcPrice();

echo $good1->total . "<br>";
echo $good2->total . "<br>";
echo $good3->total . "<br>";



























die();
/*
//CREATE
$product = new Product();
$product->name = 'Чай';
$product->price = 23;
$product->insert();

//READ
$product = new Product();
$product->getOne(5);
$product->getAll();

//UPDATE
$product = new Product();
$product->getOne(5);
$product->price = 25;
$product->update();

//DELETE
$product = new Product();
$product->getOne(5);
$product->delete();
*/