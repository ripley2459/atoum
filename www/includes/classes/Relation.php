<?php

class Relation implements IData
{
    private int $_id;
    private int $_type;
    private int $_a;
    private int $_b;
    private string $_dateCreated;

    /**
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        if (isset($id)) {
            if (self::checkTable()) {
                global $DDB;
                $s = 'SELECT * FROM ' . PREFIX . 'relations WHERE id = :id LIMIT 1';
                $r = $DDB->prepare($s);
                $r->bindValue(':id', $id, PDO::PARAM_INT);

                try {
                    $r->execute();
                    $d = $r->fetch();

                    $this->_id = $d['id'];
                    $this->_type = $d['type'];
                    $this->_a = $d['a'];
                    $this->_b = $d['b'];
                    $this->_dateCreated = $d['dateCreated'];
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
        $s = 'SHOW TABLES LIKE \'' . PREFIX . 'relations\'';
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
            $s = 'CREATE TABLE ' . PREFIX . 'relations (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                type BIGINT(20) UNSIGNED NOT NULl,
                a BIGINT(20) UNSIGNED NOT NULl,
                b BIGINT(20) UNSIGNED NOT NULl,
                dateCreated DATETIME default CURRENT_TIMESTAMP
            )';
            $r = $DDB->prepare($s);

            try {
                $r->execute();
                Logger::logInfo('Table \'relations\' has been created');
                return true;
            } catch (PDOException $e) {
                Logger::logError('Can\'t create table \'relations\'');
                Logger::logError($e->getMessage());
                return false;
            }
        }
    }

    /**
     * Enregistre une nouvelle instance dans la base de données avec les paramètres donnés.
     * @param int $type
     * @param int $a
     * @param int $b
     * @return bool Si l'instance a été enregistrée avec succès
     */
    public function registerInstance(int $type, int $a, int $b): bool
    {
        $this->_type = $type;
        $this->_a = $a;
        $this->_b = $b;

        return $this->register();
    }

    /**
     * @inheritDoc
     */
    public function register(): bool
    {
        global $DDB;

        if (self::checkTable()) {
            $s = 'INSERT INTO ' . PREFIX . 'relations SET type = :type, a = :a, b = :b';
            $r = $DDB->prepare($s);

            $r->bindValue(':type', $this->_type, PDO::PARAM_INT);
            $r->bindValue(':a', $this->_a, PDO::PARAM_INT);
            $r->bindValue(':b', $this->_b, PDO::PARAM_INT);

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
            $s = 'DELETE FROM ' . PREFIX . 'relations WHERE id = :id';
            $r = $DDB->prepare($s);

            $r->bindValue(':id', $this->_id, PDO::PARAM_INT);

            try {
                $r->execute();
                $r->closeCursor();
                return true;
            } catch (PDOException $e) {
                Logger::logError('Can\'t delete this instance from the database');
                Logger::logError($e->getMessage());
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function save(): bool
    {
        Logger::logError('Irrelevant to save a relation'); // todo
        return false;
    }
}