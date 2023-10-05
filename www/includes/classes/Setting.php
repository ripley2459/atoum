<?php

class Setting implements IData
{
    public const COLUMNS = ['id', 'name', 'content', 'dateCreated', 'dateModified'];
    protected int $_id;
    protected string $_name;
    protected string $_content;
    protected string $_dateCreated;
    protected string $_dateModified;

    public function __construct(int $id = null)
    {
        if (isset($id)) {
            global $DDB;

            $s = 'SELECT * FROM ' . PREFIX . 'settings WHERE id = :id LIMIT 1';
            $r = $DDB->prepare($s);
            $r->bindValue(':id', $id, PDO::PARAM_INT);

            try {
                $r->execute();
                $d = $r->fetch();
                $this->_id = $d['id'];
                $this->_name = $d['name'];
                $this->_content = $d['content'];
                $this->_dateCreated = $d['dateCreated'];
                $this->_dateModified = $d['dateModified'];
                $r->closeCursor();
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());
            }
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
    public static function insert(string $name, string $content = null): Setting
    {
        $args = array();

        $args['slug'] = $slug ?? R::sanitize($name);
        $args['name'] = $name;
        $args['content'] = $content ?? 'null';

        if (self::register($args)) {
            global $DDB;
            return new Setting($DDB->lastInsertId());
        } else throw new PDOException('Can\'t insert inside the database!');
    }

    /**
     * @inheritDoc
     */
    public static function register(array $args): bool
    {
        global $DDB;

        $s = 'INSERT INTO ' . PREFIX . 'settings SET name = :name, content = :content';
        $r = $DDB->prepare($s);

        $r->bindValue(':name', $args['name'], PDO::PARAM_STR);
        $r->bindValue(':content', $args['content'], PDO::PARAM_STR);

        try {
            return $r->execute() && $r->closeCursor();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public static function checkTable(): bool
    {
        global $DDB;

        $s = 'SHOW TABLES LIKE \'' . PREFIX . 'settings\'';
        $r = $DDB->prepare($s);

        try {
            $r->execute();
            if ($r->rowCount() > 0) {
                return $r->closecursor();
            } else {
                $s = 'CREATE TABLE ' . PREFIX . 'settings (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                content LONGTEXT,
                dateCreated DATETIME default CURRENT_TIMESTAMP,
                dateModified DATETIME default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )';
                return $DDB->prepare($s)->execute();
            }
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function unregister(): bool
    {
        global $DDB;

        $s = 'DELETE FROM ' . PREFIX . 'settings WHERE id = :id';
        $r = $DDB->prepare($s);
        $r->bindValue(':id', $this->_id, PDO::PARAM_INT);

        try {
            return $r->execute() && $r->closeCursor();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function update(array $args): bool
    {
        global $DDB;

        $s = 'UPDATE ' . PREFIX . 'settings SET name = :name, content = :content WHERE id = :id';
        $r = $DDB->prepare($s);

        $r->bindValue(':name', $this->_name, PDO::PARAM_STR);
        $r->bindValue(':content', $this->_content, PDO::PARAM_STR);
        $r->bindValue(':id', $this->_id, PDO::PARAM_INT);

        try {
            return $r->execute() && $r->closeCursor();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function __serialize(): array
    {
        // TODO: Implement __serialize() method.
    }

    /**
     * @inheritDoc
     */
    public function __unserialize(array $data): void
    {
        // TODO: Implement __unserialize() method.
    }
}