<?php

abstract class Content implements IData
{
    protected int $_id;
    protected int $_owner;
    protected int $_type;
    protected int $_status;
    protected int $_views;
    protected string $_slug;
    protected string $_name;
    protected string $_content;
    protected int $_parent;
    protected string $_date_created;
    protected string $_date_modified;

    /**
     * @param int $id
     */
    public function __construct(int $id = -1)
    {
        if ($id == -1) return;
    }

    /**
     * @return Content
     */
    public static abstract function getInstance(): Content;

    /**
     * Donne le type de donnée.
     * @return mixed
     */
    public static abstract function getType(): EContentType;

    /**
     * @inheritDoc
     */
    public static function checkTable(): bool
    {
        global $DDB;
        $s = 'SHOW TABLES LIKE \'' . PREFIX . 'content\'';
        $r = $DDB->prepare($s);

        try {
            $r->execute();
        } catch (PDOException $e) {
            Logger::logError('Error during check table processus');
            Logger::logError($e->getMessage());
            return false;
        }

        if ($r->rowCount() > 0) {
            return true;
        } else {
            $s = 'CREATE TABLE ' . PREFIX . 'content (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                owner BIGINT(20) UNSIGNED default 0,
                type BIGINT(20) UNSIGNED NOT NULl,
                status TINYINT(255) UNSIGNED default 0,
                views BIGINT(20) UNSIGNED default 0,
                slug VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                content LONGTEXT,
                parent BIGINT(20) UNSIGNED default 0,
                date_created DATETIME default CURRENT_TIMESTAMP,
                date_modified DATETIME default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )';
            $r = $DDB->prepare($s);

            try {
                $r->execute();
                Logger::logInfo('Table \'content\' has been created');
                return true;
            } catch (PDOException $e) {
                Logger::logError('Can\'t create table \'content\'');
                Logger::logError($e->getMessage());
                return false;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public
    function register(): bool
    {
        // TODO: Implement register() method.
    }

    /**
     * @inheritDoc
     */
    public
    function unregister(): bool
    {
        // TODO: Implement unregister() method.
    }

    /**
     * @inheritDoc
     */
    public
    function save(): bool
    {
        // TODO: Implement save() method.
    }
}