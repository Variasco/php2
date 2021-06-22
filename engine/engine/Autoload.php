<?php


class Autoload
{
    function loadClass($className)
    {
        $fileName = str_replace(["app\\", "\\"], ["../", "/"], $className) . ".php";
        if (file_exists($fileName)) {
            include $fileName;
        }
    }
}


