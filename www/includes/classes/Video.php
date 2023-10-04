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
        return FileHandler::removeFile($this);
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        $poster = RString::EMPTY;
        $path = FileHandler::getPath($this) . '.png';
        if (file_exists(UPLOADS . $path)) {
            $poster = 'poster="' . UPLOADS_URL . $path . '"';
        }

        return '<video id="' . $this->_slug . '" src="' . UPLOADS_URL . FileHandler::getPath($this) . '" controls ' . $poster . '"></video>';
    }

    public function getPreview(): string
    {
        $path = FileHandler::getPath($this) . '.png';
        if (!file_exists(UPLOADS . $path)) {
            $path = ThemeHandler::DefaultThemeURL . 'images/video-placeholder.png';
        }

        return '<img class="preview" src="' . UPLOADS_URL . $path . '"/>';
    }

    public function displayLink(): string
    {
        return '<a href="' . URL . '/index.php?page=video&video=' . $this->_id . '">' . $this->getPreview() . '</a>';
    }
}