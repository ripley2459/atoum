<?php

/**
 * This class handle relations between data stored inside the database.
 */
class Relation extends AData
{
    /**
     * The RELATION_FACTOR is an arbitrary value used to generate critical things. Changing it will break your database.
     * @var int 1000 is a good number. It allows your installation to handle 1000 EDataType different.
     */
    private const RELATION_FACTOR = 1000;

    /**
     * @var int The data type that describes the nature of this data.
     */
    protected int $type;

    /**
     * @var int The data type that describes the nature of this data.
     */
    protected int $child;

    /**
     * @var int The data type that describes the nature of this data.
     */
    protected int $parent;

    /**
     * @var string The date and time when this data was created.
     */
    protected string $dateCreated;

    /**
     * @inheritDoc
     */
    public static function getColumns(): array
    {
        return ['id', 'type', 'child', 'parent', 'dateCreated'];
    }

    /**
     * @inheritDoc
     */
    public static function checkTable(): bool
    {
        $columns = [
            'id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'type BIGINT UNSIGNED NOT NULl',
            'child BIGINT UNSIGNED NOT NULl',
            'parent BIGINT UNSIGNED NOT NULl',
            'dateCreated DATETIME default CURRENT_TIMESTAMP'
        ];

        return RDB::check(static::getTableName(), $columns)->execute();
    }

    /**
     * @inheritDoc
     */
    public static function getTableName(): string
    {
        return 'relations';
    }

    /**
     * @inheritDoc
     */
    public static function getInsertableColumns(): array
    {
        return ['type', 'child', 'parent'];
    }

    /**
     * @inheritDoc
     */
    public static function getUpdatableColumns(): array
    {
        return [];
    }

    /**
     * Gives the type of objects based on a relationship type.
     * @param int $type The relation type.
     * @return EDataType[] Index 0 is child and index 1 is parent.
     */
    public static function getTypesFrom(int $type): array
    {
        $d = $type / self::RELATION_FACTOR;
        if (is_int($d)) {
            $t = array();
            $t[0] = EDataType::from($d);
            $t[1] = EDataType::from(0);
            return $t;
        }

        $t = explode(".", $d);
        $t[0] = EDataType::from($t[0]);
        $t[1] = EDataType::from($t[1]);
        return $t;
    }

    /**
     * Gives all related data of a reference of a certain type.
     * @param AContent $reference
     * @param EDataType $child
     * @param bool $selectChild
     * @param int $amount
     * @return array
     */
    public static function getRelated(AContent $reference, EDataType $child, bool $selectChild = true, int $amount = -1): array
    {
        $data = RDB::select(self::getTableName(), $selectChild ? 'child' : 'parent')
            ->where('type', '=', $selectChild ? self::getTypeFor($child, $reference->getType()) : self::getTypeFor($reference->getType(), $child))
            ->where($selectChild ? 'parent' : 'child', '=', $reference->getId())
            ->execute();

        $values = array();
        while ($d = $data->fetch(PDO::FETCH_ASSOC))
            $values[] = new Content($d[$selectChild ? 'child' : 'parent']);
        $data->closeCursor();

        if ($amount > 0) { // TODO Implement a cleaner way to get this!
            shuffle($values);
            $values = array_slice($values, 0, $amount);
        }

        return $values;
    }

    /**
     * Gives the number that connects two data together.
     * @param EDataType $child
     * @param EDataType $parent
     * @return int The relation type.
     * @see getTypes()
     */
    public static function getTypeFor(EDataType $child, EDataType $parent): int
    {
        return self::getTypes()[$child->name][$parent->name];
    }

    /**
     * Return an array containing possible relation types.
     * @return array
     */
    private static function getTypes(): array
    {
        $r = array();
        foreach (EDataType::cases() as $sub) {
            $domValue = $sub->value * self::RELATION_FACTOR;
            foreach (EDataType::cases() as $dom)
                $r[$sub->name][$dom->name] = $domValue + $dom->value;
        }

        return $r;
    }

    /**
     * @return int The type of the relation.
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * Removes every occurrence of this data.
     * Use it when you want to delete something from the database that may be related to anything.
     * @param AContent $data
     * @return bool
     */
    public static function remove(AData $data): bool
    {
        return RDB::delete(self::getTableName())
            ->where('child', '=', $data->getId())
            ->or()
            ->where('parent', '=', $data->getId())
            ->execute();
    }

    /**
     * Removes every relation of a certain type.
     * @param AContent $data The parent data
     * @param EDataType $target The type to remove
     * @return bool
     */
    public static function clear(AData $data, EDataType $target): bool
    {
        return RDB::delete(self::getTableName())
            ->where('type', '=', self::getTypeFor($target, $data->getType()))
            ->where('parent', '=', $data->getId())
            ->execute();
    }

    /**
     * Returns all data of a certain type indirectly associated with a reference.
     * @param AContent $reference
     * @param EDataType $first
     * @param EDataType $second
     * @param int $amount
     * @return array
     */
    public static function getRelatedStepped(AContent $reference, EDataType $first, EDataType $second, $amount = -1): array
    {
        $sub = RDB::select(self::getTableName(), 'child')
            ->where('type', '=', self::getTypeFor($first, $reference->getType()))
            ->where('parent', '=', $reference->getId());

        $data = RDB::select(self::getTableName(), 'parent')
            ->where('type', '=', self::getTypeFor($first, $second))
            ->where('child')->in($sub)->execute();

        $values = array();
        while ($d = $data->fetch(PDO::FETCH_ASSOC))
            $values[] = new Content($d['parent']);
        $data->closeCursor();

        if ($amount > 0) { // TODO Implement a cleaner way to get this!
            shuffle($values);
            $values = array_slice($values, 0, $amount);
        }

        return $values;
    }

    public static function exists(int $child, int $parent): bool
    {
        $request = RDB::select(self::getTableName(), 'id')
            ->where('type', '=', self::getTypeFrom($child, $parent))
            ->where('child', '=', $child)
            ->where('parent', '=', $parent);

        $data = $request->execute();

        return $data->rowCount() > 0 && $data->closeCursor();
    }

    /**
     * Gives the number that connects two data together.
     * @param int $child
     * @param int $parent
     * @return int The relation type.
     * @see getTypes()
     * @deprecated
     */
    public static function getTypeFrom(int $child, int $parent): int
    {
        $child = new Content($child);
        $parent = new Content($parent);
        return self::getTypeFor($child->getType(), $parent->getType());
    }

    /**
     * @return int
     */
    public function getChild(): int
    {
        return $this->child;
    }

    /**
     * @return int
     */
    public function getParent(): int
    {
        return $this->parent;
    }

    /**
     * @return DateTime The date and time when this relation was created.
     * @throws Exception
     */
    public function getDateCreated(): DateTime
    {
        return new DateTime($this->dateCreated);
    }
}