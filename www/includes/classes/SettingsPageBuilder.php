<?php

class SettingsPageBuilder
{
    const ALLOWED_PAGES = ['settings', 'editorGallery', 'galleries', 'actors', 'uploads', 'tags'];
    private static ?SettingsPageBuilder $_instance = null;
    private string $_page;
    private array $_scripts = array();

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

    public function build(): void
    {
        if (isset($_GET['page']) && in_array($_GET['page'], self::ALLOWED_PAGES, true)) {
            $this->_page = $_GET['page'];
            $this->head();
            $this->header();
            $this->body();
            $this->footer();
        } else {
            header('Location: ' . URL . '/settings/index.php?page=settings');
            die();
        }
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
    public function body(): void
    {
        include SETTINGS . $this->_page . '.php';
    }

    /**
     * Fonction pour inclure le morceau de page.
     * @return void Affiche directement le morceau de page.
     */
    public function footer(): void
    {
        include SETTINGS . 'footer.php';
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