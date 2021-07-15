<?php

use app\models\repositories\{CartRepository, CategoryRepository, OrderRepository, ProductRepository, UserRepository};
use app\engine\{Request, Db, Session};

return [
    'root' => dirname(__DIR__),
    'controllers_namespaces' => 'app\\controllers\\',
    'quantity' => 3,
    'statuses' => [
        'оформлен',
        'обработан',
        'отправлен',
        'доставлен'
    ],
    'views_dir' => dirname(__DIR__) . "/views/",
    'components' => [
        'db' => [
            'class' => Db::class,
            'driver' => 'mysql',
            'host' => 'localhost',
            'login' => 'root',
            'password' => 'root',
            'database' => 'shop',
            'charset' => 'utf8'
        ],
        'request' => [
            'class' => Request::class
        ],
        'session' => [
            'class' => Session::class
        ],
        'cartRepository' => [
            'class' => CartRepository::class
        ],
        'productRepository' => [
            'class' => ProductRepository::class
        ],
        'userRepository' => [
            'class' => UserRepository::class
        ],
        'orderRepository' => [
            'class' => OrderRepository::class
        ],
        'categoryRepository' => [
            'class' => CategoryRepository::class
        ],
    ]
];
