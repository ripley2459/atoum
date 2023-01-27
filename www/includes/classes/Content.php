<?php

abstract class Content implements IData
{
    const COLUMNS = ['id', 'owner', 'type', 'status', 'views', 'slug', 'name', 'content', 'parent', 'date_created', 'date_modified'];
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
    public string $_date_modified;

    /**
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        if (isset($id)) {
            global $DDB;
            $s = 'SELECT * FROM ' . PREFIX . 'contents WHERE id = :id LIMIT 1';
            $r = $DDB->prepare($s);
            $r->bindValue(':id', $id, PDO::PARAM_INT);

            try {
                $r->execute();
                $d = $r->fetch();

                $this->_id = $d['id'];
                $this->_owner = $d['owner'];
                $this->_type = $d['type'];
                $this->_status = $d['status'];
                $this->_views = $d['views'];
                $this->_slug = $d['slug'];
                $this->_name = $d['name'];
                $this->_content = $d['content'];
                $this->_parent = $d['parent'];
                $this->_date_created = $d['date_created'];
                $this->_date_modified = $d['date_modified'];
            } catch (PDOException $e) {
                Logger::logError('Can\'t get this instance from database');
                Logger::logError($e->getMessage());
            }
        }
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

    public static function getAll(string $type = null, string $orderBy = null): array
    {
        global $DDB;
        if (self::checkTable()) {
            $s = 'SELECT id, type FROM ' . PREFIX . 'contents';

            if (isset($type)) {
                $type = whitelist((int)$type, EContentType::values());
                $s .= ' WHERE type = ' . $type;
            }

            if (isset($orderBy)) {
                $orderParameters = explode("_", $orderBy);
                $orderBy = whitelist($orderParameters[0], self::COLUMNS);
                $orderDirection = whitelist($orderParameters[1], ['ASC', 'DESC']);

                $s .= ' ORDER BY ' . $orderBy . ' ' . $orderDirection;
            }

            $r = $DDB->prepare($s);

            try {
                $r->execute();

                $content = [];

                while ($d = $r->fetch()) {
                    $newContent = self::createInstance(EContentType::fromInt($d['type']), $d['id']);
                    $content[] = $newContent;
                }

                $r->closeCursor();
                return $content;
            } catch (PDOException $e) {
                Logger::logError('Can\'t get all instances from database');
                Logger::logError($e->getMessage());
                return [];
            }
        }
    }

    /**
     * @inheritDoc
     */
    public static function checkTable(): bool
    {
        global $DDB;
        $s = 'SHOW TABLES LIKE \'' . PREFIX . 'contents\'';
        $r = $DDB->prepare($s);

        try {
            $r->execute();
        } catch (PDOException $e) {
            Logger::logError('Error during check table process');
            Logger::logError($e->getMessage());
            return false;
        }

        if ($r->rowCount() > 0) {
            return true;
        } else {
            $s = 'CREATE TABLE ' . PREFIX . 'contents (
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
                Logger::logInfo('Table \'contents\' has been created');
                return true;
            } catch (PDOException $e) {
                Logger::logError('Can\'t create table \'contents\'');
                Logger::logError($e->getMessage());
                return false;
            }
        }
    }

    /**
     * Crée une nouvelle instance en fonction d'un type donné.
     * @param EContentType $mimeType
     * @param int|null $id
     * @return Content
     * @throws Exception Dans le cas où le type n'est pas supporté
     */
    public static function createInstance(EContentType $mimeType, int $id = null): Content
    {
        return match ($mimeType) {
            EContentType::MOVIE => new Movie($id),
            EContentType::IMAGE => new Image($id),
            EContentType::GALLERY => new Gallery($id),
            EContentType::PLAYLIST => new Playlist($id),
            EContentType::POST => new Post($id),
            EContentType::PAGE => new Page($id),
            EContentType::COMMENT => new Comment($id),
            default => throw new Exception('This type is not supported!')
        };
    }

    /**
     * Enregistre une nouvelle instance dans la base de données avec les paramètres donnés.
     * @param int $owner
     * @param int $type
     * @param int $status
     * @param int $views
     * @param string $slug
     * @param string $name
     * @param string|null $content
     * @param int $parent
     * @return bool Si l'instance a été enregistrée avec succès
     */
    public function registerInstance(int $owner, int $type, int $status, int $views, string $slug, string $name, ?string $content, int $parent): bool
    {
        $this->_owner = $owner;
        $this->_type = $type;
        $this->_status = $status;
        $this->_views = $views;
        $this->_slug = $slug;
        $this->_name = $name;
        $this->_content = $content;
        $this->_parent = $parent;

        return $this->register();
    }

    /**
     * @inheritDoc
     */
    public function register(): bool
    {
        global $DDB;

        if (self::checkTable()) {
            $s = 'INSERT INTO ' . PREFIX . 'contents SET owner = :owner, type = :type, status = :status, views = :views, slug = :slug, name = :name, content = :content, parent = :parent';
            $r = $DDB->prepare($s);

            $r->bindValue(':owner', $this->_owner, PDO::PARAM_INT);
            $r->bindValue(':type', $this->_type, PDO::PARAM_INT);
            $r->bindValue(':status', $this->_status, PDO::PARAM_INT);
            $r->bindValue(':views', $this->_views, PDO::PARAM_INT);
            $r->bindValue(':slug', $this->_slug, PDO::PARAM_STR);
            $r->bindValue(':name', $this->_name, PDO::PARAM_STR);
            $r->bindValue(':content', $this->_content, PDO::PARAM_STR);
            $r->bindValue(':parent', $this->_parent, PDO::PARAM_INT);

            try {
                $r->execute();
                return true;
            } catch (PDOException $e) {
                Logger::logError('Can\'t register new instance in database');
                Logger::logError($e->getMessage());
                return false;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function unregister(): bool
    {
        global $DDB;

        if (self::checkTable()) {
            // TODO: Implement unregister() method.
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function save(): bool
    {
        global $DDB;

        if (self::checkTable()) {
            // TODO: Implement save() method.
        }

        return false;
    }
}