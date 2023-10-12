<?php

class Content implements IData
{
    public const COLUMNS = ['id', 'owner', 'type', 'status', 'views', 'slug', 'name', 'content', 'parent', 'dateCreated', 'dateModified'];
    protected int $_id;
    protected int $_owner;
    protected EDataType $_type;
    protected EDataStatus $_status;
    protected int $_views;
    protected string $_slug;
    protected string $_name;
    protected string $_content;
    protected int $_parent;
    protected string $_dateCreated;
    protected string $_dateModified;

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
                $this->_type = EDataType::from($d['type']);
                $this->_status = EDataStatus::from($d['status']);
                $this->_views = $d['views'];
                $this->_slug = $d['slug'];
                $this->_name = $d['name'];
                $this->_content = $d['content'];
                $this->_parent = $d['parent'];
                $this->_dateCreated = $d['dateCreated'];
                $this->_dateModified = $d['dateModified'];
                $r->closeCursor();
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());
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
            if ($r->rowCount() > 0) {
                return $r->closecursor();
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
                return $DDB->prepare($s)->execute() && $r->closeCursor();
            }
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * Convenient method.
     * Enregistre une nouvelle instance dans la base de données avec les paramètres donnés et renvois l'instance crée.
     * @param int $owner
     * @param EDataType $type
     * @param EDataStatus $status
     * @param string $name
     * @param string|null $slug
     * @param string|null $content
     * @param int $views
     * @param int $parent
     * @return Content Instance créée.
     * @throws Exception
     */
    public static function insert(int $owner, EDataType $type, string $name, string $slug = null, string $content = null, int $views = 0, int $parent = 0, EDataStatus $status = EDataStatus::PUBLISHED): Content
    {
        $args = array();

        $args['owner'] = $owner;
        $args['type'] = $type;
        $args['status'] = $status;
        $args['views'] = $views;
        $args['slug'] = $slug ?? R::sanitize($name);
        $args['name'] = $name;
        $args['content'] = $content ?? 'null';
        $args['parent'] = $parent;

        if (self::register($args)) {
            global $DDB;
            return self::get($DDB->lastInsertId(), $type);
        } else throw new PDOException('Can\'t insert inside the database!');
    }

    /**
     * @inheritDoc
     */
    public static function register(array $args): bool
    {
        global $DDB;

        $s = 'INSERT INTO ' . PREFIX . 'contents SET owner = :owner, type = :type, status = :status, views = :views, slug = :slug, name = :name, content = :content, parent = :parent';
        $r = $DDB->prepare($s);

        $r->bindValue(':owner', $args['owner'], PDO::PARAM_INT);
        $r->bindValue(':type', $args['type']->value, PDO::PARAM_INT);
        $r->bindValue(':status', $args['status']->value, PDO::PARAM_INT);
        $r->bindValue(':views', $args['views'], PDO::PARAM_INT);
        $r->bindValue(':slug', $args['slug'], PDO::PARAM_STR);
        $r->bindValue(':name', $args['name'], PDO::PARAM_STR);
        $r->bindValue(':content', $args['content'], PDO::PARAM_STR);
        $r->bindValue(':parent', $args['parent'], PDO::PARAM_INT);

        try {
            return $r->execute() && $r->closeCursor();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * Convenient method to retrieve an instance from the database with the correct class.
     * @param int $id
     * @param EDataType $type
     * @return Content
     */
    public static function get(int $id, EDataType $type): Content
    {
        return match ($type) {
            EDataType::VIDEO => new Video($id),
            EDataType::IMAGE => new Image($id),
            default => new Content($id)
        };
    }

    /**
     * @return EDataType
     */
    public function getType(): EDataType
    {
        return $this->_type;
    }

    /**
     * @inheritDoc
     */
    public function unregister(): bool
    {
        global $DDB;

        $s = 'DELETE FROM ' . PREFIX . 'contents WHERE id = :id';
        $r = $DDB->prepare($s);
        $r->bindValue(':id', $this->_id, PDO::PARAM_INT);

        $flag = true;
        if ($this instanceof IFile || $this->_type == EDataType::IMAGE || $this->_type == EDataType::VIDEO) $flag = $this->deleteContent();
        if ($flag) {
            try {
                return $r->execute() && $r->closeCursor();
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());
            }
        } else throw new RuntimeException('Can\'t delete associated files!');
    }

    /**
     * @inheritDoc
     */
    public function update(array $args): bool
    {
        global $DDB;

        $this->_name = $args['name'] ?? $this->_name;

        $s = 'UPDATE ' . PREFIX . 'contents SET owner = :owner, type = :type, status = :status, views = :views, slug = :slug, name = :name, content = :content, parent = :parent WHERE id = :id';
        $r = $DDB->prepare($s);

        $r->bindValue(':owner', $this->_owner, PDO::PARAM_INT);
        $r->bindValue(':type', $this->_type->value, PDO::PARAM_INT);
        $r->bindValue(':status', $this->_status->value, PDO::PARAM_INT);
        $r->bindValue(':views', $this->_views, PDO::PARAM_INT);
        $r->bindValue(':slug', $this->_slug, PDO::PARAM_STR);
        $r->bindValue(':name', $this->_name, PDO::PARAM_STR);
        $r->bindValue(':content', $this->_content, PDO::PARAM_STR);
        $r->bindValue(':parent', $this->_parent, PDO::PARAM_INT);
        $r->bindValue(':id', $this->_id, PDO::PARAM_INT);

        try {
            return $r->execute() && $r->closeCursor();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function getRelatedFrom(EDataType $second, EDataType $first): array
    {
        global $DDB;
        $firstArray = $this->getRelated($first);
        if (count($firstArray) > 0) {
            $in = R::EMPTY;
            foreach ($firstArray as $elem) {
                if ($elem->getId() != $this->_id) $in .= $elem->getId() . ',';
            }

            $in = substr($in, 0, -1);

            $s = 'SELECT parent FROM ' . PREFIX . 'relations WHERE type = :type AND child IN (' . $in . ')';
            $r = $DDB->prepare($s);
            $r->bindValue(':type', Relation::getRelationType($first, $second), PDO::PARAM_INT);

            try {
                $r->execute();

                $related = array();
                while ($d = $r->fetch(PDO::FETCH_ASSOC)) {
                    if ($d['parent'] != $this->_id) $related[] = Content::get($d['parent'], $second);
                }

                $r->closeCursor();
                return $related;
            } catch (PDOException $e) {
                Logger::logError($e->getMessage());
            } catch (Exception $f) {
                Logger::logError($f->getMessage());
            }
        }

        return array();
    }

    public function getRelated(EDataType $type): array
    {
        $r = Request::select(PREFIX . 'relations', 'child')
            ->where('type', '=', Relation::getRelationType($type, $this->_type))
            ->where('parent', '=', $this->_id);
        $data = $r->execute();

        $related = array();
        while ($d = $data->fetch(PDO::FETCH_ASSOC)) {
            if ($d['child'] != $this->_id) $related[] = self::get($d['child'], $type);
        }

        return $related;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    public function increaseViews(): bool
    {
        global $DDB;
        $s = 'UPDATE ' . PREFIX . 'contents SET views = views + 1 WHERE id = :id';
        $r = $DDB->prepare($s);
        $r->bindValue(':id', $this->_id, PDO::PARAM_INT);
        return $r->execute() && $r->closeCursor();
    }

    /**
     * @return int
     */
    public function getOwner(): int
    {
        return $this->_owner;
    }

    /**
     * @return EDataStatus
     */
    public function getStatus(): EDataStatus
    {
        return $this->_status;
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
     * @return string
     * @throws Exception
     */
    public function getDateCreatedFormatted(): string
    {
        $date = new DateTime($this->_dateCreated);
        return $date->format('d F Y');
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
     * Donne du code HTML pour afficher cette élément.
     * @return string
     */
    public function display(): string
    {
        return '<p>' . $this->_name . '</p>';
    }
}