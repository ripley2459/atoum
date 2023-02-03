<?php

class Logger
{
    const DATE_FORMAT = 'Y-m-d H:i:s';
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

    public static function logError(string $text): void
    {
        Logger::log('[ERROR] ' . $text);
    }

    public static function log(string $text): void
    {
        $f = fopen(DIR . "/log.txt", 'a');
        fwrite($f, '[' . date(self::DATE_FORMAT) . ']' . $text . "\n");
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