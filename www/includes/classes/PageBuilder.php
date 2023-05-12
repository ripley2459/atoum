<?php

class PageBuilder
{
    const ALLOWED_PAGES = ['welcome', 'home', 'viewGallery', 'viewVideo', 'galleries', 'videos'];
    private static ?PageBuilder $_instance = null;
    private string $_page;
    private array $_scripts = array();

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

    public function build(): void
    {
        if (isset($_GET['page']) && in_array($_GET['page'], self::ALLOWED_PAGES, true)) {
            $this->_page = $_GET['page'];
            $this->head();
            $this->header();
            $this->body();
            $this->footer();
        } else {
            header('Location: ' . URL . '/index.php?page=' . self::ALLOWED_PAGES[0]);
            die();
        }
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function head(): void
    {
        include THEME . 'head.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function header(): void
    {
        include THEME . 'header.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function body(): void
    {
        include THEME . $this->_page . '.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function footer(): void
    {
        include THEME . 'footer.php';
    }

    public function isWelcome(): bool
    {
        return $this->_page === self::ALLOWED_PAGES[0];
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function index(): void
    {
        include THEME . 'index.php';
    }

    public function injectScript(string $script): void
    {
        $this->_scripts[] = $script;
    }

    public function displayScripts(): void
    {
        if (count($this->_scripts) > 0) {
            foreach ($this->_scripts as $script) {

                echo '<script>';
                echo $script;
                echo '</script>';
            }
        }
    }
}