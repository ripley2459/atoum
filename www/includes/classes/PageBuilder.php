<?php

class PageBuilder
{
    const ALLOWED_PAGES = ['welcome', 'home'];

    private static ?PageBuilder $_instance = null;
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

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function index(): void
    {
        include THEME . 'index.php';
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
        $page = isset($_GET['page']) ? whitelist($_GET['page'], self::ALLOWED_PAGES) : self::ALLOWED_PAGES[0];
        include THEME . $page . '.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function footer(): void
    {
        include THEME . 'footer.php';
    }


    /**
     * Permet d'ajouter le script JavaScript donné en pied de page.
     * @param string $id
     * @param string $content
     * @return void
     */
    public function injectScript(string $id, string $content): void
    {
        $this->_scripts[$id] = $content;
    }

    public function displayScripts(): void
    {
        if (count($this->_scripts) > 0) {
            echo '<script>';
            foreach ($this->_scripts as $script) {
                echo $script;
            }
            echo '</script>';
        }
    }
}