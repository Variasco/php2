<?php


namespace app\engine;


use app\interfaces\IRender;

class Render implements IRender
{

    public function renderTemplate($template, $params = [])
    {
        ob_start();
        extract($params);
        $templatePath = App::call()->config['views_dir'] . $template . '.php';
        if (file_exists($templatePath)) {
            include $templatePath;
            return ob_get_clean();
        } else {
            die('Шаблон не существует');
        }
    }
}
