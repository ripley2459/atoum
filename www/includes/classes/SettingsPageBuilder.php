<?php

class SettingsPageBuilder
{
    const ALLOWED_PAGES = ['settings', 'galleries', 'uploads'];

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
     * @return void Affiche directement le morceau de page.
     */
    public function head(): void
    {
        include SETTINGS . 'head.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function header(): void
    {
        include SETTINGS . 'header.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function footer(): void
    {
        include SETTINGS . 'footer.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function body(): void
    {
        $page = isset($_GET['page']) ? whitelist($_GET['page'], self::ALLOWED_PAGES) : self::ALLOWED_PAGES[0];
        include SETTINGS . $page . '.php';
    }
}