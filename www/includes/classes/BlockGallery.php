<?php

class BlockGallery extends ABlock
{
    private int $_columnCount = 4;
    private array $_images = array();

    public function __construct(string $id = R::EMPTY, string $classes = R::EMPTY)
    {
        parent::__construct($id, $classes);
        R::append($this->_classes, R::SPACE, 'gallery');
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return '<div ' . $this->signature() . '>' . $this->getGrid() . $this->getModal() . '</div>';
    }

    private function getGrid(): string
    {
        $r = '<div id="' . $this->_id . '-grid" class="gallery grid" style="column-count: ' . $this->_columnCount . '">';
        $pointer = 0;
        foreach ($this->_images as $image) {
            $r .= '<img src="' . UPLOADS_URL . FileHandler::getPath($image) . '" onclick="showSlide(' . ++$pointer . ', \'' . $this->_id . '\')">';
        }
        $r .= '</div>';

        return $r;
    }

    private function getModal(): string
    {
        return '<div id="' . $this->_id . '-modal" class="gallery modal">' . $this->getFeedbacks() . $this->getSlideshow() . $this->getThumbnails() . '</div>';
    }

    private function getSlideshow(): string
    {
        $r = '<div id="' . $this->_id . '-slideshow" class="gallery slideshow">';
        foreach ($this->_images as $image) {
            $r .= '<img class="slide" src="' . UPLOADS_URL . FileHandler::getPath($image) . '">';
        }
        $r .= '</div>';

        return $r;
    }

    private function getThumbnails(): string
    {
        $r = '<div id="' . $this->_id . '-thumbnails" class="gallery thumbnails">';
        $pointer = 0;
        foreach ($this->_images as $image) {
            $r .= '<img src="' . UPLOADS_URL . FileHandler::getPath($image) . '" class="thumbnail" onclick="showSlide(' . ++$pointer . ', \'' . $this->_id . '\')">';
        }
        $r .= '</div>';

        return $r;
    }

    public function getImages(int $galleryId, bool $random = false): void
    {
        $images = Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY), $galleryId);
        if ($random) shuffle($images);
        foreach ($images as $image) {
            $this->addImage($image);
        }
    }

    public function addImage(Image $image): void
    {
        $this->_images[] = $image;
    }

    public function getFeedbacks(): string
    {
        return '<div id="' . $this->_id . '-feedbacks" class="gallery feedbacks">></div>';
    }
}