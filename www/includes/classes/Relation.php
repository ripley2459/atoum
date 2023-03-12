<?php

class Relation implements IData
{
    private const RELATION_FACTOR = 1000;
    private int $_id;
    private int $_type;
    private int $_child;
    private int $_parent;
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
                    $this->_child = $d['child'];
                    $this->_parent = $d['parent'];
                    $this->_dateCreated = $d['dateCreated'];
                } catch (PDOException $e) {
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
            Logger::logError($e->getMessage());
            return false;
        }

        if ($r->rowCount() > 0) {
            return true;
        } else {
            $s = 'CREATE TABLE ' . PREFIX . 'relations (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                type BIGINT(20) UNSIGNED NOT NULl,
                child BIGINT(20) UNSIGNED NOT NULl,
                parent BIGINT(20) UNSIGNED NOT NULl,
                dateCreated DATETIME default CURRENT_TIMESTAMP
            )';
            $r = $DDB->prepare($s);

            try {
                $r->execute();
                return true;
            } catch (PDOException $e) {
                Logger::logError($e->getMessage());
                return false;
            }
        }
    }

    /**
     * Permet de connaitre le nombre décrivant la relation entre deux objets.
     * Pour faire simple, l'objet A sera lié à l'objet B.
     * @param EDataType $child
     * @param EDataType $parent
     * @return int
     * @see getRelationsTypes()
     */
    public static function getRelationType(EDataType $child, EDataType $parent): int
    {
        return self::getRelationsTypes()[$child->name][$parent->name];
    }

    /**
     * Construit et donne le tableau des types de relations possibles.
     * @return array
     */
    public static function getRelationsTypes(): array
    {
        $r = array();

        foreach (EDataType::cases() as $sub) {
            $domValue = $sub->value * self::RELATION_FACTOR;
            foreach (EDataType::cases() as $dom) {
                $r[$sub->name][$dom->name] = $domValue + $dom->value;
            }
        }

        return $r;
    }

    /**
     * Donne les éléments liés à un certain parent pour un certain type de relation.
     * Donne par exemple les images liées à une galerie.
     * @param int $relationType
     * @param int $parent
     * @param bool $invert Pour ne prendre que les éléments non liés au parent donné.
     * @return AContent[]
     * @throws Exception
     */
    public static function getChildren(int $relationType, int $parent, bool $invert = false): array
    {
        if (self::checkTable()) {
            global $DDB;
            $s = 'SELECT * FROM ' . PREFIX . 'relations WHERE type = :type AND parent ' . ($invert ? '<>' : '=') . ' :parent';
            $r = $DDB->prepare($s);

            $r->bindValue(':type', $relationType, PDO::PARAM_INT);
            $r->bindValue(':parent', $parent, PDO::PARAM_INT);

            try {
                $r->execute();

                $children = array();

                while ($d = $r->fetch(PDO::FETCH_ASSOC)) {
                    $newContent = AContent::createInstance(self::getElementsTypes($relationType)[0], $d['child']);
                    $children[] = $newContent;
                }

                $r->closeCursor();
                return $children;
            } catch (PDOException $e) {
                Logger::logError($e->getMessage());
                return array();
            }
        }

        return array();
    }

    /**
     * @param int $type
     * @return EDataType[]
     */
    public static function getElementsTypes(int $type): array
    {
        $t = explode(".", $type / self::RELATION_FACTOR);
        $t[0] = EDataType::fromInt($t[0]);
        $t[1] = EDataType::fromInt($t[1]);
        return $t;
    }

    public static function relationExists(int $type, int $child, int $parent): bool
    {
        if (self::checkTable()) {
            global $DDB;
            $s = 'SELECT * FROM ' . PREFIX . 'relations WHERE type = :type AND child = :child AND parent = :parent';
            $r = $DDB->prepare($s);

            $r->bindValue(':type', $type, PDO::PARAM_INT);
            $r->bindValue(':child', $child, PDO::PARAM_INT);
            $r->bindValue(':parent', $parent, PDO::PARAM_INT);

            try {
                $r->execute();
                $d = $r->rowCount();
                $r->closeCursor();
                return $d > 0;
            } catch (PDOException $e) {
                Logger::logError($e->getMessage());
            }
        }

        return false;
    }

    public static function getRelation(int $type, int $child, int $parent): Relation
    {
        if (self::checkTable()) {
            global $DDB;
            $s = 'SELECT id FROM ' . PREFIX . 'relations WHERE type = :type AND child = :child AND parent = :parent LIMIT 1';
            $r = $DDB->prepare($s);

            $r->bindValue(':type', $type, PDO::PARAM_INT);
            $r->bindValue(':child', $child, PDO::PARAM_INT);
            $r->bindValue(':parent', $parent, PDO::PARAM_INT);

            try {
                $r->execute();
                $d = $r->fetch(PDO::FETCH_ASSOC);
                return new Relation($d['id']);
            } catch (PDOException $e) {
                Logger::logError($e->getMessage());
            }
        }

        return new Relation();
    }

    /**
     * Enregistre une nouvelle instance dans la base de données avec les paramètres donnés.
     * @param int $type
     * @param int $child
     * @param int $parent
     * @return bool Si l'instance a été enregistrée avec succès
     */
    public function registerInstance(int $type, int $child, int $parent): bool
    {
        $this->_type = $type;
        $this->_child = $child;
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
            $s = 'INSERT INTO ' . PREFIX . 'relations SET type = :type, child = :child, parent = :parent';
            $r = $DDB->prepare($s);

            $r->bindValue(':type', $this->_type, PDO::PARAM_INT);
            $r->bindValue(':child', $this->_child, PDO::PARAM_INT);
            $r->bindValue(':parent', $this->_parent, PDO::PARAM_INT);

            try {
                $r->execute();
                return true;
            } catch (PDOException $e) {
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