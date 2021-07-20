<?php
session_start();

use app\engine\App;
use app\exceptions\{RequestException, ApiException, AuthException};

$config = include "../config/config.php";
include '../vendor/autoload.php';

try {
    App::call()->run($config);

} catch (PDOException $e) {
    echo "PDOException Error! {$e->getMessage()}";
} catch (RequestException $e) {
    echo "RequestException Error! {$e->getMessage()}";
} catch (ApiException $e) {
    echo "ApiException Error! {$e->getMessage()}";
} catch (AuthException $e) {
    echo "AuthException Error! {$e->getMessage()}";
} catch (Exception $e) {
    echo "Exception Error! {$e->getMessage()}";
}


// Добавлен сервисный класс App, как единая точка входа
// Добавлено хранилище Storage для создания и хранения всех экземпляров классов
// Созданы миграции и сиды для базы данных
// Добавлена возможность оформления заказа из корзины
// Добавлен функционал в админку. Можно увидеть все заказы и просмотреть каждый в деталях, а так же изменить его статус
// Реализована ассинхронная автоматическая подргузка каталога. Добавлена блокировка в API против новых запросов, когда каталог исчерпал себя
