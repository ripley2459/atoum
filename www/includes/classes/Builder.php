<?php

class Builder
{
    private static string $_page;

    /**
     * Build the whole page.
     * @return void
     */
    public static function build(): void
    {
        self::$_page = R::whitelist($_GET['page'] ?? 'home', ALLOWED_PAGES, 'home');
        self::head();
        self::header();
        self::body();
        self::footer();
    }

    /**
     * Display the head of the page.
     * @return void
     */
    private static function head(): void
    {
        require_once INCLUDES . 'head.php';
    }

    /**
     * Display the header of the page.
     * @return void
     */
    private static function header(): void
    {
        require_once INCLUDES . 'header.php';
    }

    /**
     * Display the body of the page.
     * @return void
     */
    private static function body(): void
    {
        require_once INCLUDES . 'pages/' . self::$_page . '.php';
    }

    /**
     * Display the footer of the page.
     * @return void
     */
    private static function footer(): void
    {
        require_once INCLUDES . 'footer.php';
    }

    public static function title(): string
    {
        return 'Page title!';
    }

    public static function description(): string
    {
        return 'Page description';
    }

    public static function author(): string
    {
        return 'Cyril Neveu';
    }

    /**
     * Return an array containing search arguments.
     * @return ['display', 'type', 'status', 'order', 'limit', 'search', 'view']
     */
    public static function searchArgs(): array
    {
        $args = array();

        $args['display'] = $_GET['display'] ?? 1;
        $args['type'] = isset($_GET['type']) && $_GET['type'] != -1 ? R::whitelist(intval($_GET['type']), EDataType::values()) : null;
        $args['status'] = isset($_GET['status']) ? R::whitelist(intval($_GET['status']), EDataStatus::values()) : EDataStatus::PUBLISHED->value;
        $args['order'] = $_GET['order'] ?? 'dateCreated_ASC';
        $args['limit'] = $_GET['limit'] ?? 100;
        $args['search'] = isset($_GET['search']) && !R::nullOrEmpty($_GET['search']) ? $_GET['search'] : null;
        $args['view'] = $_GET['view'] ?? 1;

        return $args;
    }
}