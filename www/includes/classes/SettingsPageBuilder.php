<?php

class SettingsPageBuilder
{
    private static ?SettingsPageBuilder $_instance = null;

    private function __construct()
    {
    }

    /**
     * Singleton.
     * @return SettingsPageBuilder
     */
    public static function Instance(): SettingsPageBuilder
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new SettingsPageBuilder();
        }
        return self::$_instance;
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void
     */
    public function head(): void
    {
        include SETTINGS_INCLUDES . 'head.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void
     */
    public function header(): void
    {
        include SETTINGS_INCLUDES . 'header.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void
     */
    public function footer(): void
    {
        include SETTINGS_INCLUDES . 'footer.php';
    }
}