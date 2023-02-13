<?php

abstract class AContent implements IData
{
    public const COLUMNS = ['id', 'owner', 'type', 'status', 'views', 'slug', 'name', 'content', 'parent', 'dateCreated', 'dateModified'];
    public string $_dateModified;
    protected int $_id;
    protected int $_owner;
    protected int $_type;
    protected int $_status;
    protected int $_views;
    protected string $_slug;
    protected string $_name;
    protected string $_content;
    protected int $_parent;
    protected string $_dateCreated;

    /**
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        if (isset($id)) {
            if (self::checkTable()) {
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
                    $this->_dateCreated = $d['dateCreated'];
                    $this->_dateModified = $d['dateModified'];
                } catch (PDOException $e) {
                    Logger::logError('Can\'t get this instance from database');
                    Logger::logError($e->getMessage());
                }
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
                dateCreated DATETIME default CURRENT_TIMESTAMP,
                dateModified DATETIME default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
     * @param int $id
     * @return AContent
     */
    public static function getInstance(int $id): AContent
    {
        global $DDB;

        if (self::checkTable()) {
            $s = 'SELECT id, type FROM ' . PREFIX . 'contents WHERE id = :id LIMIT 1';
            $r = $DDB->prepare($s);
            $r->bindValue(':id', $id, PDO::PARAM_INT);

            try {
                $r->execute();
                $d = $r->fetch();
                return self::createInstance(EContentType::fromInt($d['type']), $d['id']);
            } catch (Exception $e) {
                Logger::logError('Can\'t get instance from database');
                Logger::logError($e->getMessage());
            }
        }
    }

    /**
     * Crée une nouvelle instance en fonction d'un type donné.
     * @param EContentType $mimeType
     * @param int|null $id
     * @return AContent
     * @throws Exception Dans le cas où le type n'est pas supporté
     */
    public static function createInstance(EContentType $mimeType, int $id = null): AContent
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
     * Donne le type de donnée.
     * @return mixed
     */
    public static abstract function getType(): EContentType;

    /**
     * @param int|null $type
     * @param int|null $status
     * @param string|null $orderBy
     * @param int $limit
     * @param int|null $currentPage La page actuelle pour la pagination
     * @return array
     * @throws Exception
     */
    public static function getAll(int $type = null, int $status = null, string $orderBy = null, int $limit = 100, int $currentPage = null): array
    {
        global $DDB;

        if (self::checkTable()) {
            $s = 'SELECT id, type FROM ' . PREFIX . 'contents';

            if (isset($type) || isset($status)) {
                $s .= ' WHERE ';
                if (isset($type)) {
                    $type = whitelist($type, EContentType::values());
                    $sType = ' type = ' . $type;
                }
                if (isset($status)) {
                    $status = whitelist($status, EContentStatus::values());
                    $sStatus = ' status = ' . $status;
                }
                if (isset($sType) && isset($sStatus)) {
                    $s .= $sType . ' AND ' . $sStatus;
                }
                if (isset($sType) && !isset($sStatus)) {
                    $s .= $sType;
                }
                if (!isset($sType) && isset($sStatus)) {
                    $s .= $sStatus;
                }
            }

            if (isset($orderBy)) {
                $orderParameters = explode("_", $orderBy);
                $orderBy = whitelist($orderParameters[0], self::COLUMNS);
                $orderDirection = whitelist($orderParameters[1], ['ASC', 'DESC']);

                $s .= ' ORDER BY ' . $orderBy . ' ' . $orderDirection;
            }

            $s .= isset($currentPage) ? ' LIMIT :limitMin, :limitMax' : ' LIMIT :limit';

            $r = $DDB->prepare($s);

            if (isset($currentPage)) {
                $r->bindValue(':limitMin', $currentPage * $limit - $limit, PDO::PARAM_INT);
                $r->bindValue(':limitMax', $limit, PDO::PARAM_INT);
            } else {
                $r->bindValue(':limit', $limit, PDO::PARAM_INT);
            }

            try {
                $r->execute();

                $content = [];

                while ($d = $r->fetch(PDO::FETCH_ASSOC)) {
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

    public static function getAmount(int $type = null): int
    {
        global $DDB;
        if (self::checkTable()) {
            $s = 'SELECT COUNT(id) AS amount FROM ' . PREFIX . 'contents';

            if (isset($type)) {
                $type = whitelist($type, EContentType::values());
                $s .= ' WHERE type = ' . $type;
            }

            $r = $DDB->prepare($s);

            try {
                $r->execute();
                $d = $r->fetch(PDO::FETCH_ASSOC);
                $amount = (int)$d['amount'];
                $r->closeCursor();
                return $amount;
            } catch (PDOException $e) {
                Logger::logError('Can\'t get the amount of registered instance in database');
                Logger::logError($e->getMessage());
                return -1;
            }
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @return int
     */
    public function getOwner(): int
    {
        return $this->_owner;
    }

    /**
     * @return EContentStatus
     */
    public function getStatus(): EContentStatus
    {
        return EContentStatus::fromInt($this->_status);
    }

    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->_views;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->_slug;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->_content;
    }

    /**
     * @return int
     */
    public function getParent(): int
    {
        return $this->_parent;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getDateCreated(): DateTime
    {
        return new DateTime($this->_dateCreated);
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getDateModified(): DateTime
    {
        return new DateTime($this->_dateModified);
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
            $s = 'DELETE FROM ' . PREFIX . 'contents WHERE id = :id';
            $r = $DDB->prepare($s);

            $r->bindValue(':id', $this->_id, PDO::PARAM_INT);

            $flag = true;
            if ($this instanceof IFile) {
                $flag = $this->deleteContent();
            }

            if ($flag) {
                try {
                    $r->execute();
                    $r->closeCursor();
                    return true;
                } catch (PDOException $e) {
                    Logger::logError('Can\'t delete this instance from the database');
                    Logger::logError($e->getMessage());
                }
            }
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