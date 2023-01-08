<?php

class FileHandler
{
    private static ?FileHandler $_instance = null;

    private function __construct()
    {
    }

    /**
     * Singleton.
     * @return FileHandler
     */
    public static function Instance(): FileHandler
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new FileHandler();
        }
        return self::$_instance;
    }
}