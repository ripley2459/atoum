<?php

class Content extends AContent
{
    /**
     * @var int The ID of the owner or creator of this data.
     */
    protected int $owner;

    /**
     * @var int The data type that describes the nature of this data.
     */
    protected int $type;

    /**
     * @var int The status of this data, e.g., published, draft, etc.
     */
    protected int $status;

    /**
     * @var int The number of views or interactions with this data.
     */
    protected int $views;

    /**
     * @var string The URL-friendly slug for this data.
     */
    protected string $slug;

    /**
     * @var string The name or title of this data.
     */
    protected string $name;

    /**
     * @var string The content or body of this data.
     */
    protected string $content;

    /**
     * @var int The ID of the parent data if applicable.
     */
    protected int $parent;

    /**
     * @var string The date and time when this data was created.
     */
    protected string $dateCreated;

    /**
     * @var string The date and time when this data was last modified.
     */
    protected string $dateModified;

    /**
     * @inheritDoc
     */
    public static function getColumns(): array
    {
        return ['id', 'owner', 'type', 'status', 'views', 'slug', 'name', 'content', 'parent', 'dateCreated', 'dateModified'];
    }

    /**
     * @inheritDoc
     */
    public static function getUpdatableColumns(): array
    {
        return ['owner', 'type', 'status', 'views', 'slug', 'name', 'content', 'parent'];
    }

    /**
     * @inheritDoc
     */
    public static function checkTable(): bool
    {
        $columns = [
            'id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner BIGINT UNSIGNED default 0',
            'type BIGINT UNSIGNED NOT NULl',
            'status TINYINT(255) UNSIGNED default 0',
            'views BIGINT UNSIGNED default 0',
            'slug VARCHAR(255) NOT NULL',
            'name VARCHAR(255) NOT NULL',
            'content LONGTEXT',
            'parent BIGINT UNSIGNED default 0',
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
        return 'contents';
    }

    /**
     * @inheritDoc
     */
    public static function getInsertableColumns(): array
    {
        return ['owner', 'type', 'status', 'slug', 'name', 'content', 'parent'];
    }

    /**
     * @return int The ID of the owner or creator of this data.
     */
    public function getOwner(): int
    {
        return $this->owner;
    }

    /**
     * @inheritDoc
     */
    public function getType(): EDataType
    {
        return EDataType::from($this->type);
    }

    /**
     * @return int The status of this data, e.g., published, draft, etc.
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int The number of views or interactions with this data.
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @return string The URL-friendly slug for this data.
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string The name or title of this data.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string The content or body of this data.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int The ID of the parent data if applicable.
     */
    public function getParent(): int
    {
        return $this->parent;
    }

    /**
     * @return DateTime The date and time when this data was created.
     * @throws Exception
     */
    public function getDateCreated(): DateTime
    {
        return new DateTime($this->dateCreated);
    }

    /**
     * @return DateTime The date and time when this data was last modified.
     * @throws Exception
     */
    public function getDateModified(): DateTime
    {
        return new DateTime($this->dateModified);
    }

    /**
     * @inheritDoc
     */
    public function unregister(): bool
    {
        $unregister = parent::unregister();
        $rename = true;
        if ($unregister && ($this->type == EDataType::IMAGE->value || $this->type == EDataType::VIDEO->value)) {
            $path = FileHandler::getPath($this);
            $info = R::pathInfo($path);
            $deletedName = $info['dirname'] . '/DELETED_' . $info['basename'];
            $rename = rename($path, $deletedName);
            if ($this->type == EDataType::VIDEO->value && file_exists($path . '.png'))
                $rename &= rename($path . '.png', $deletedName . '.png');
        }

        return $unregister && $rename;
    }

    /**
     * @inheritDoc
     */
    public function update(array $data): bool
    {
        $old = FileHandler::getPath($this);
        $update = parent::update($data);

        $rename = true;
        if ($update && ($this->type == EDataType::IMAGE->value || $this->type == EDataType::VIDEO->value)) {
            $new = FileHandler::getPath($this);
            $rename = rename($old, $new);
            if ($this->type == EDataType::VIDEO->value && file_exists($old . '.png'))
                $rename &= rename($old . '.png', $new . '.png');
        }

        return $update && $rename;
    }

    public function __toString(): string
    {
        return $this->slug;
    }
}