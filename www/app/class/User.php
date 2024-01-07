<?php

class User extends AContent
{
    /**
     * @var string The unique name of this user.
     */
    protected string $username;

    /**
     * @var string The name of this user.
     */
    protected string $name;

    /**
     * @var string The password of this user.
     */
    protected string $password;

    /**
     * @var int The permission level of this user.
     */
    protected int $permissionLevel;

    /**
     * @var string The date and time when this user was created.
     */
    protected string $dateCreated;

    /**
     * @var string The date and time when this user was last modified.
     */
    protected string $dateModified;

    /**
     * @inheritDoc
     */
    public static function getColumns(): array
    {
        return ['id', 'username', 'name', 'password', 'permissionLevel', 'dateCreated', 'dateModified'];
    }

    /**
     * @inheritDoc
     */
    public static function getUpdatableColumns(): array
    {
        return ['name', 'password', 'permissionLevel'];
    }

    /**
     * @inheritDoc
     */
    public static function checkTable(): bool
    {
        $columns = [
            'id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'username VARCHAR(255) NOT NULL',
            'name VARCHAR(255) NOT NULL',
            'password VARCHAR(255) NOT NULL',
            'permissionLevel BIGINT UNSIGNED default 0',
            'dateCreated DATETIME default CURRENT_TIMESTAMP',
            'dateModified DATETIME default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];

        return RDB::check(static::getTableName(), $columns)->execute();
    }

    /**
     * @inheritDoc
     */
    public static function getTableName(): string
    {
        return 'users';
    }

    /**
     * @inheritDoc
     */
    public static function getInsertableColumns(): array
    {
        return ['username', 'name', 'password', 'permissionLevel'];
    }

    /**
     * @inheritDoc
     */
    public function getType(): EDataType
    {
        return EDataType::USER;
    }
}