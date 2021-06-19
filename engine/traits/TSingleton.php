<?php


namespace app\traits;

trait TSingleton
{
    private static $instance = null;

    /**
     * @return static
     */
    public static function getInstance() {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}
