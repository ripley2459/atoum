<?php

/**
 * The App is the base class to build the website.
 */
class App
{
    protected static string $_page;
    protected static string $_title = 'Default title';
    protected static string $_description = 'Default description';
    protected static string $_author = 'Default author';
    protected static array $_searchArguments;
    protected static string $_buffer;

    /**
     * Build the whole page.
     * Act as a basic rooter.
     * Start/Restart the session and store the current location of the client.
     * Then we are serving different elements.
     * @return void
     */
    public static function build(): void
    {
        Auth::start();
        Auth::set('location', URL . $_SERVER['REQUEST_URI']);

        ob_start();
        self::$_page = R::whitelist($_GET['page'] ?? LANDING_PAGE, ALLOWED_PAGES, LANDING_PAGE);

        require_once path_PUBLIC . 'include/head.php';
        require_once path_PUBLIC . 'include/header.php';
        require_once path_PUBLIC . 'page/' . self::$_page . '.php';
        require_once path_PUBLIC . 'include/footer.php';

        self::$_buffer = ob_get_contents();

        self::$_buffer = str_replace(self::getTitlePlaceholder(), self::$_title, self::$_buffer);
        self::$_buffer = str_replace(self::getDescriptionPlaceholder(), self::$_description, self::$_buffer);
        self::$_buffer = str_replace(self::getAuthorPlaceholder(), self::$_author, self::$_buffer);

        ob_end_clean();
        echo self::$_buffer;
    }

    /**
     * @return string
     */
    public static function getTitlePlaceholder(): string
    {
        return '%%TITLE%%';
    }

    /**
     * @param string $title
     */
    public static function setTitle(string $title): void
    {
        self::$_title = $title;
    }

    /**
     * @return string
     */
    public static function getDescriptionPlaceholder(): string
    {
        return '%%DESCRIPTION%%';
    }

    /**
     * @param string $description
     */
    public static function setDescription(string $description): void
    {
        self::$_description = $description;
    }

    /**
     * @return string
     */
    public static function getAuthorPlaceholder(): string
    {
        return '%%AUTHOR%%';
    }

    /**
     * @param string $author
     */
    public static function setAuthor(string $author): void
    {
        self::$_author = $author;
    }

    /**
     * Redirects the user to the specified page.
     * @param string $page The destination page to which the user will be redirected.
     * @return void
     * @see getLink()
     */
    public static function redirect(string $page): void
    {
        header('Location: ' . self::getLink($page));
    }

    /**
     * Generates a formatted link based on the provided page name.
     * @param string $page The page identifier to be included in the link.
     * @param string ...$args The URL parameters to add. Accept any parameter in the shape of "name=value".
     * @return string The formatted link consisting of the base URL and the whitelisted page name.
     */
    public static function getLink(string $page, string ...$args): string
    {
        $l = URL . '/' . R::whitelist($page, ALLOWED_PAGES) . '.php';
        if (!R::blank($args))
            $l .= '?' . R::concat('&', $args);
        return $l;
    }

    /**
     * Generates a URL for including a file from the 'public/include/' directory.
     * @param string $file The full name of the file to include.
     * @return string The full URL for including the specified file.
     */
    public static function include(string $file): string
    {
        return URL . '/public/include/' . $file;
    }

    public static function require(string $file): void
    {
        include path_PUBLIC . '/include/' . $file;
    }

    /**
     * Generates a formatted link based on the provided function name.
     * @param string $function The function identifier to be included in the link.
     * @return string The formatted link consisting of the base URL and the function name.
     */
    public static function getFunction(string $function): string
    {
        return URL . '/app/entry.php?function=' . $function;
    }

    /**
     * Returns the search parameters filtered and sanitized.
     * @return array
     */
    public static function args(): array
    {
        if (!isset(self::$_searchArguments)) {
            self::$_searchArguments = array(
                'limit' => intval(R::getParameter('limit', 100)),
                'offset' => intval(R::getParameter('offset', 1)),
                'type' => intval(R::getParameter('type', -1)),
                'search' => R::getParameter('search', R::EMPTY),
                'actors' => json_decode(urldecode(R::getParameter('actors', R::EMPTY)), true) ?? [],
                'tags' => json_decode(urldecode(R::getParameter('tags', R::EMPTY)), true) ?? [],
                'orderBy' => explode('_', R::getParameter('orderBy', 'dateCreated_DESC'))
            );
        }

        return self::$_searchArguments;
    }
}