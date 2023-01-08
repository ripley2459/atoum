<?php

class PageBuilder
{
    private static ?PageBuilder $_instance = null;

    private function __construct()
    {
    }

    /**
     * Singleton.
     * @return PageBuilder
     */
    public static function Instance(): PageBuilder
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new PageBuilder();
        }
        return self::$_instance;
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void
     */
    public function index(): void
    {
        include THEME . 'index.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void
     */
    public function head(): void
    {
        include THEME . 'head.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void
     */
    public function header(): void
    {
        include THEME . 'header.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void
     */
    public function body(): void
    {
        include THEME . 'body.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void
     */
    public function footer(): void
    {
        include THEME . 'footer.php';
    }
}