<?php

class Image extends Content implements IFile
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
}