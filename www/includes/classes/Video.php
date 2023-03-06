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
    public function display(bool $echo = true): string
    {
        $r = '<video id="movie' . $this->_id . '" src="' . UPLOADS_URL . FileHandler::getPath($this) . '" controls></video>';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }
}