<?php


namespace app\controllers;


use app\interfaces\IRender;
use app\models\User;

abstract class MainController
{
    protected $action;
    protected $layout = 'main';
    protected $useLayout = true;

    private $render;

    /**
     * MainController constructor.
     * @param $render
     */
    public function __construct(IRender $render)
    {
        $this->render = $render;
    }


    public function runAction($action) {
        $this->action = $action;
        $method = 'action' . ucfirst($this->action);
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            die("Экшен не существует");
        }
    }

    protected function render($template, $params = []) {
        if ($this->useLayout) {
            return $this->renderTemplate("layouts/{$this->layout}", [
                'menu' => $this->renderTemplate('menu', [
                    'isAuth' => User::isAuth(),
                    'userName' => User::getUser(),
                    'isAdmin' => User::isAdmin()
                ]),
                'content' => $this->renderTemplate($template, $params)
            ]);
        } else {
            return $this->renderTemplate($template, $params);
        }
    }

    protected function renderTemplate($template, $params = []) {
        return $this->render->renderTemplate($template, $params);
    }

//    protected function renderTemplate($template, $params = []) {
//        ob_start();
//        extract($params);
//        $templatePath = VIEWS_DIR . $template . '.php';
//        if (file_exists($templatePath)) {
//            include $templatePath;
//            return ob_get_clean();
//        } else {
//            die('Шаблона не существует');
//        }
//    }
}
