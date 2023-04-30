<?php

class Video extends AContent implements IFile
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::VIDEO;
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
    public function display(): string
    {
        return '<video id="' . $this->_slug . '" src="' . UPLOADS_URL . FileHandler::getPath($this) . '" controls></video>';
    }
}