<?php


namespace app\engine;


use app\interfaces\IRender;

class TwigRender implements IRender
{
    protected $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../viewsTwig');
        $this->twig = new \Twig\Environment($loader);
    }


    public function renderTemplate($template, $params = [])
    {
        $templateName = "{$template}.twig";
        if (file_exists("../viewsTwig/{$templateName}")) {
            return $this->twig->render($templateName, $params);
        } else {
            die('Шаблон не существует');
        }
    }
}
