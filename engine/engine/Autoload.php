<?php


class Autoload
{
    function loadClass($className)
    {
        $fileName = str_replace(["app\\", "\\"], [".." . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $className) . ".php";
        if (file_exists($fileName)) {
            include $fileName;
        }
    }
}


