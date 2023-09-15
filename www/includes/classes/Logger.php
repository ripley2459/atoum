<?php

class Logger
{
    const DATE_FORMAT = 'Y-m-d H:i:s';
    private static float $_startTime;
    private static float $_endTime;

    public static function logError(string $text): void
    {
        self::log('[ERROR] ' . $text);
    }

    private static function log(string $text): void
    {
        $f = fopen(DIR . "/log.txt", 'a');
        fwrite($f, '[' . date(self::DATE_FORMAT) . ']' . $text . "\n");
        fclose($f);
    }

    public static function logInfo(string $text): void
    {
        self::log('[INFO] ' . $text);
    }
    
    public static function clear(): void
    {
        $f = fopen(DIR . '/log.txt', 'w');
        fclose($f);
    }

    /**
     * Starts measuring script execution time.
     * Allows to have a very naive estimation of performances.
     * In no way replaces a real profiling tool.
     * @return void
     * @see measure
     * @see stopMeasure
     */
    public static function startMeasure(): void
    {
        self::$_startTime = microtime(true);
    }

    /**
     * Displays the execution time value with "var_dump" without ending the measurement.
     * Allows to have a very naive estimation of performances.
     * In no way replaces a real profiling tool.
     * @return void
     * @see startMeasure
     * @see stopMeasure
     */
    public static function measure(): void
    {
        var_dump(microtime(true) - self::$_startTime);
    }

    /**
     * Terminates the script execution time measurement and displays the value with "var_dump".
     * Allows to have a very naive estimation of performances.
     * In no way replaces a real profiling tool.
     * @return void
     * @see startMeasure
     * @see measure
     */
    public static function stopMeasure(): void
    {
        self::$_endTime = microtime(true);
        var_dump((self::$_endTime - self::$_startTime) * 1000);
    }
}