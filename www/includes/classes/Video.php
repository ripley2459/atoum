<?php

class Video extends Content implements IFile
{
    /**
     * @inheritDoc
     */
    public function deleteContent(): bool
    {
        $path = UPLOADS . '/' . $this->getUploadedDate()->format(FileHandler::DATE_FORMAT) . '/';
        return rename($path . $this->getUploadName(), $path . 'DELETED_' . $this->getUploadName())
            && rename($path . $this->getUploadName() . '.png', $path . 'DELETED_' . $this->getUploadName() . '.png');
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
    public function getUploadName(): string
    {
        return $this->_slug;
    }

    /**
     * @inheritDoc
     */
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
        $path = $this->hasPoster() ? UPLOADS_URL . FileHandler::getPath($this) . '.png' : URL . '/content/themes/video-placeholder.png';
        return $inVideo ? 'poster="' . $path . '"' : '<img class="preview" src="' . $path . '"/>';
    }

    public function hasPoster(): bool
    {
        return file_exists(UPLOADS . FileHandler::getPath($this) . '.png');
    }

    /**
     * Donne du code HTML pour avoir un lecteur vidéo permettant de lire cette video.
     * @return string
     */
    public function player(): string
    {
        return '<video id="' . $this->_slug . '" src="' . UPLOADS_URL . FileHandler::getPath($this) . '" controls ' . $this->getPoster(true) . '></video>';
    }

    /**
     * @inheritDoc
     */
    public function update(array $args): bool
    {
        $infos = pathinfo($this->_slug);
        $before = UPLOADS . FileHandler::getPath($this);
        $this->_slug = R::sanitize($args['name'] ?? $this->_name) . '.' . $infos['extension'];
        $flag = parent::update($args);

        if ($flag) {
            $after = UPLOADS . FileHandler::getPath($this);
            $flag = rename($before, $after);
            rename($before . '.png', $after . '.png');
        }

        return $flag;
    }
}