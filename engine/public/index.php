<?php
session_start();

use app\exceptions\{RequestException, ApiException, AuthException};
use app\engine\{Render, Request, Session, TwigRender};
use app\models\entities\{Product, User, Order, Cart, Category};

include "../config/config.php";
include '../vendor/autoload.php';

try {
    $request = new Request;

    $controllerName = $request->getControllerName() ?: 'index';
    $actionName = $request->getActionName() ?? 'index';

    $controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass(new Render());
        $controller->runAction($actionName);
    } else {
        throw new RequestException("Контроллер не существует");
    }
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
