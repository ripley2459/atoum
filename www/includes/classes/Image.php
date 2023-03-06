<?php

class Image extends AContent implements IFile
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::IMAGE;
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

    /**
     * @inheritDoc
     */
    public function display(bool $echo = true): string
    {
        $r = '<img id="image' . $this->_id . '" src="' . UPLOADS_URL . FileHandler::getPath($this) . '">';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }
}