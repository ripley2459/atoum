<?php

class Movie extends AContent implements IFile
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::MOVIE;
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