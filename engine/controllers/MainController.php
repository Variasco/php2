<?php


namespace app\controllers;


use app\exceptions\RequestException;
use app\engine\{App};
use app\interfaces\IRender;

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
            throw new RequestException("Экшен не существует");
        }
    }

    protected function render($template, $params = []) {
        if ($this->useLayout) {
            $user = App::call()->userRepository;
            return $this->renderTemplate("layouts/{$this->layout}", [
                'menu' => $this->renderTemplate('menu', [
                    'isAuth' => $user->isAuth(),
                    'userName' => $user->getUser(),
                    'isAdmin' => $user->isAdmin(),
                    'count' => App::call()->cartRepository->getCountWhere('session_id', App::call()->session->getSessionId())
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
