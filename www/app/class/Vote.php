<?php

class Vote extends AData
{
    /**
     * @var int The ID of the content to which this vote is associated.
     */
    protected int $content;

    /**
     * @var int The ID of the user who submitted this vote.
     */
    protected int $owner;

    /**
     * @var int The value of this vote. Should be -1 in case of a dislike and 1 in case of a like.
     */
    protected int $value;

    /**
     * @var string The date and time when this vote was created.
     */
    protected string $dateCreated;

    /**
     * @inheritDoc
     */
    public static function getColumns(): array
    {
        return ['id', 'content', 'owner', 'value', 'dateCreated'];
    }

    /**
     * @inheritDoc
     */
    public static function checkTable(): bool
    {
        $columns = [
            'id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'content BIGINT UNSIGNED NOT NULL',
            'owner BIGINT UNSIGNED NOT NULL',
            'value TINYINT NOT NULL',
            'dateCreated DATETIME default CURRENT_TIMESTAMP',
        ];

        return RDB::check(static::getTableName(), $columns)->execute();
    }

    /**
     * @inheritDoc
     */
    public static function getTableName(): string
    {
        return 'votes';
    }

    /**
     * @inheritDoc
     */
    public static function getInsertableColumns(): array
    {
        return ['content', 'owner', 'value'];
    }

    /**
     * @inheritDoc
     */
    public static function getUpdatableColumns(): array
    {
        return ['value'];
    }

    /**
     * @return int The ID of the content to which this vote is associated.
     */
    public function getContent(): int
    {
        return $this->content;
    }

    /**
     * @return int The ID of the user who submitted this vote.
     */
    public function getOwner(): int
    {
        return $this->owner;
    }

    /**
     * @return int The value of this vote. Should be -1 in case of a dislike and 1 in case of a like.
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return DateTime The date and time when this data was created.
     * @throws Exception
     */
    public function getDateCreated(): DateTime
    {
        return new DateTime($this->dateCreated);
    }
}