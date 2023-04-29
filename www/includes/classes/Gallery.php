<?php

class Gallery extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::GALLERY;
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        $gallery = new BlockGallery($this->_slug);
        $gallery->setColumnCount(5);
        $images = Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY), $this->_id);

        foreach ($images as $image) {
            $gallery->addImage($image);
        }

        return $gallery->display();
    }
}