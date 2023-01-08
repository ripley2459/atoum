<?php

class ThemeHandler
{
    private static ?ThemeHandler $_instance = null;
    private string $_themeName;
    private string $_themePath;

    private function __construct()
    {
        $this->_themeName = Setting::value('theme');
        $this->_themePath = $this->_themeName == 'atoum' ? INCLUDES . 'themes/atoum/' : CONTENT . 'themes/' . $this->_themeName . '/';
    }

    /**
     * Singleton.
     * @return ThemeHandler
     */
    public static function Instance(): ThemeHandler
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new ThemeHandler();
        }
        return self::$_instance;
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->_themeName;
    }

    /**
     * @return string
     */
    public function getThemePath(): string
    {
        return $this->_themePath;
    }
}