<?php

class BlockGallery extends ABlock
{
    private int $_columnCount = 4;
    private array $_images = array();

    public function __construct(string $id = RString::EMPTY, string $classes = RString::EMPTY)
    {
        parent::__construct($id, $classes);
        RString::concat($this->_classes, RString::SPACE, 'gallery');
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return '<div ' . $this->getSignature() . '>' . $this->getGrid() . $this->getModal() . '</div>';
    }

    private function getGrid(): string
    {
        $r = '<div id="' . $this->_id . 'Grid" class="gallery grid" style="column-count: ' . $this->_columnCount . '">';
        $pointer = 0;
        foreach ($this->_images as $image) {
            $r .= '<img src="' . UPLOADS_URL . FileHandler::getPath($image) . '" onclick="currentSlide(' . ++$pointer . ', \'' . $this->_id . '\')">';
        }
        $r .= '</div>';

        return $r;
    }

    private function getModal(): string
    {
        return '<div id="' . $this->_id . 'Modal" class="gallery modal">' . $this->getSlideshow() . $this->getThumbnails() . '</div>';
    }

    private function getSlideshow(): string
    {
        $r = '<div id="' . $this->_id . 'Slideshow" class="gallery slideshow">';
        foreach ($this->_images as $image) {
            $r .= '<img src="' . UPLOADS_URL . FileHandler::getPath($image) . '" class="slide">';
        }
        $r .= '</div>';

        return $r;
    }

    private function getThumbnails(): string
    {
        $r = '<div id="' . $this->_id . 'Thumbnails" class="gallery thumbnails">';
        $pointer = 0;
        foreach ($this->_images as $image) {
            $r .= '<img src="' . UPLOADS_URL . FileHandler::getPath($image) . '" class="thumbnail" onclick="currentSlide(' . ++$pointer . ', \'' . $this->_id . '\')">';
        }
        $r .= '</div>';

        return $r;
    }

    /**
     * Ajoute une image à cette grille.
     * @param Image $image
     * @return void
     */
    public function addImage(Image $image): void
    {
        $this->_images[] = $image;
    }

    /**
     * Change le nombre de colonnes de ce bloc.
     * @param int $newCount
     * @return void
     */
    public function setColumnCount(int $newCount): void
    {
        $this->_columnCount = $newCount;
    }
}