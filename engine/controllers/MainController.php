<?php


namespace app\controllers;


use app\engine\{Request, Session};
use app\interfaces\IRender;
use app\models\{Cart, User};

abstract class MainController
{
    protected $action;
    protected $layout = 'main';
    protected $useLayout = true;

    private $render;

    private $request;
    private $session;

    /**
     * MainController constructor.
     * @param $render
     */
    public function __construct(IRender $render)
    {
        $this->render = $render;
    }

    protected function getRequest() {
        if (is_null($this->request)) {
            $this->request = new Request();
        }
        return $this->request;
    }

    protected function getSession() {
        if (is_null($this->session)) {
            $this->session = new Session();
        }
        return $this->session;
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
            $user = new User();
            return $this->renderTemplate("layouts/{$this->layout}", [
                'menu' => $this->renderTemplate('menu', [
                    'isAuth' => $user->isAuth(),
                    'userName' => $user->getUser(),
                    'isAdmin' => $user->isAdmin(),
                    'count' => (new Cart())->getCountWhere('session_id', session_id())
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
}
