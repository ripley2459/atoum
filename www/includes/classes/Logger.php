<?php

class Logger
{
    private static ?Logger $_instance = null;

    private function __construct()
    {
    }

    /**
     * Singleton.
     * @return Logger
     */
    public static function Instance(): Logger
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Logger();
        }
        return self::$_instance;
    }

    public static function logError(string $t): void
    {
        Logger::log('[' . date("Y-m-d H:i:s") . ']' . '[ERROR] ' . $t);
    }

    public static function log(string $text): void
    {
        $f = fopen(DIR . "/log.txt", 'a');
        fwrite($f, '[' . date("Y/m/d-H:i:s") . ']' . $text . "\n");
        fclose($f);
    }

    public static function logInfo(string $text): void
    {
        Logger::log('[INFO] ' . $text);
    }

    public static function clear(): void
    {
        $f = fopen(DIR . '/log.txt', 'w');
        fclose($f);
    }
}