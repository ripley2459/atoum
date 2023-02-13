<?php

class Image extends AContent implements IFile
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::IMAGE;
    }

    /**
     * @inheritDoc
     */
    public function getUploadedDate(): DateTime
    {
        return $this->getDateCreated();
    }

    /**
     * @inheritDoc
     */
    public function deleteContent(): bool
    {
        // TODO: Implement deleteContent() method.
    }

    /**
     * @inheritDoc
     */
    public function getUploadName(): string
    {
        return $this->_slug;
    }
}