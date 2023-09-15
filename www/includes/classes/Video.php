<?php

class Video extends Content implements IFile
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

    #[\Override]
    public function display(): string
    {
        return '<a href="' . URL . '/index.php?page=video&id=' . $this->_id . '">' . $this->getPoster() . '</a>';
    }

    /**
     * Donne du code HTML pour afficher l'image de preview de la video ou l'image par défaut.
     * @param bool $inVideo true pour avoir "poster=link"
     * @return string
     */
    public function getPoster(bool $inVideo = false): string
    {
        $path = FileHandler::getPath($this) . '.png';
        $path = file_exists(UPLOADS . $path) ? UPLOADS_URL . $path : URL . '/content/themes/video-placeholder.png';
        if ($inVideo) return 'poster="' . $path . '"';
        return '<img class="preview" src="' . $path . '"/>';
    }

    /**
     * Donne du code HTML pour avoir un lecteur vidéo permettant de lire cette video.
     * @return string
     */
    public function player(): string
    {
        return '<video id="' . $this->_slug . '" src="' . UPLOADS_URL . FileHandler::getPath($this) . '" controls ' . $this->getPoster(true) . '></video>';
    }
}