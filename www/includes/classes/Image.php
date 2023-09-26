<?php

class Image extends Content implements IFile
{
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
    public function getUploadName(): string
    {
        return $this->_slug;
    }

    /**
     * @inheritDoc
     */
    public function deleteContent(): bool
    {
        return FileHandler::removeFile($this);
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return '<img id="' . $this->_slug . '" src="' . UPLOADS_URL . FileHandler::getPath($this) . '"/>';
    }
}