<?php

/**
 * La classe Relation représente un lien entre deux EDataType.
 * Stocké sous forme de int unsigned dans la base de données, une relation est construite comme suit:
 * RELATION_FACTOR * CHILD_TYPE + PARENT_TYPE.
 * A est lié à B si et seulement si un ligne existe contenant child=A->ID & parent=B->ID.
 */
class Relation implements IData
{
    public const COLUMNS = ['id', 'type', 'child', 'parent', 'dateCreated'];
    private const RELATION_FACTOR = 1000;
    private int $_id;
    private int $_type;
    private int $_child;
    private int $_parent;
    private string $_dateCreated;

    public function __construct(int $id = null)
    {
        if (isset($id)) {
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
                $r->closeCursor();
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());
            }
        }
    }

    /**
     * Permet de connaitre le nombre décrivant la relation entre deux objets.
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

    public static function relationExists(int $type, int $child, int $parent): bool
    {
        global $DDB;

        $s = 'SELECT * FROM ' . PREFIX . 'relations WHERE type = :type AND child = :child AND parent = :parent';
        $r = $DDB->prepare($s);

        $r->bindValue(':type', $type, PDO::PARAM_INT);
        $r->bindValue(':child', $child, PDO::PARAM_INT);
        $r->bindValue(':parent', $parent, PDO::PARAM_INT);

        try {
            return $r->execute() && $r->rowCount() > 0 && $r->closeCursor();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * Supprime toutes les relations d'un type donné pour un objet.
     * @param int $relationType
     * @param int $contentId
     * @return void
     * @throws Exception
     */
    public static function purgeFor(int $relationType, int $contentId): void
    {
        foreach (Relation::getChildren($relationType, $contentId, true) as $relation) {
            $relation->unregister();
        }
    }

    /**
     * Donne les éléments liés à un certain parent pour un certain type de relation.
     * Donne par exemple les images liées à une galerie.
     * @param int $relationType
     * @param int $parent
     * @param bool $asRelation
     * @param bool $invert Pour ne prendre que les éléments non liés au parent donné.
     * @return Content[]|Relation[]
     * @throws Exception
     */
    public static function getChildren(int $relationType, int $parent, bool $asRelation = false, bool $invert = false): array
    {
        global $DDB;

        $s = 'SELECT * FROM ' . PREFIX . 'relations WHERE type = :type AND parent ' . ($invert ? '<>' : '=') . ' :parent';
        $r = $DDB->prepare($s);

        $r->bindValue(':type', $relationType, PDO::PARAM_INT);
        $r->bindValue(':parent', $parent, PDO::PARAM_INT);

        try {
            $r->execute();
            $children = array();

            while ($d = $r->fetch(PDO::FETCH_ASSOC)) {
                if ($asRelation) {
                    $newRelation = new Relation($d['id']);
                    $children[] = $newRelation;
                } else {
                    $newContent = Content::get($d['child'], self::getTypesFromRelation($relationType)[0]);
                    $children[] = $newContent;
                }
            }

            $r->closeCursor();
            return $children;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @param int $type
     * @return EDataType[]
     */
    public static function getTypesFromRelation(int $type): array
    {
        if (is_int($type / self::RELATION_FACTOR)) {
            $t = array();
            $t[0] = EDataType::from($type / self::RELATION_FACTOR);
            $t[1] = EDataType::from(0);
            return $t;
        }

        $t = explode(".", $type / self::RELATION_FACTOR);
        $t[0] = EDataType::from($t[0]);
        $t[1] = EDataType::from($t[1]);
        return $t;
    }

    /**
     * @inheritDoc
     */
    public function unregister(): bool
    {
        global $DDB;
        $s = 'DELETE FROM ' . PREFIX . 'relations WHERE id = :id';
        $r = $DDB->prepare($s);
        $r->bindValue(':id', $this->_id, PDO::PARAM_INT);

        try {
            return $r->execute() && $r->closeCursor();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * Enregistre une nouvelle instance dans la base de données avec les paramètres donnés.
     * @param int $type
     * @param int $child
     * @param int $parent
     * @return bool Si l'instance a été enregistrée avec succès
     */
    public static function insert(int $type, int $child, int $parent): bool
    {
        $args = array();
        $args['type'] = $type;
        $args['child'] = $child;
        $args['parent'] = $parent;
        return self::register($args);
    }

    /**
     * @param array $args
     * @inheritDoc
     */
    public static function register(array $args): bool
    {
        global $DDB;

        $s = 'INSERT INTO ' . PREFIX . 'relations SET type = :type, child = :child, parent = :parent';
        $r = $DDB->prepare($s);

        $r->bindValue(':type', $args['type'], PDO::PARAM_INT);
        $r->bindValue(':child', $args['child'], PDO::PARAM_INT);
        $r->bindValue(':parent', $args['parent'], PDO::PARAM_INT);

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

        $s = 'SHOW TABLES LIKE \'' . PREFIX . 'relations\'';
        $r = $DDB->prepare($s);

        try {
            $r->execute();
            if ($r->rowCount() > 0) {
                return $r->closecursor();
            } else {
                $s = 'CREATE TABLE ' . PREFIX . 'relations (
                    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    type BIGINT(20) UNSIGNED NOT NULl,
                    child BIGINT(20) UNSIGNED NOT NULl,
                    parent BIGINT(20) UNSIGNED NOT NULl,
                    dateCreated DATETIME default CURRENT_TIMESTAMP
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
    public function update(array $args): bool
    {
        Logger::logError('Irrelevant to save a relation');
        return false;
    }
}