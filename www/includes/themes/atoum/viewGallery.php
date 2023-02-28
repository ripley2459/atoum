<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['gallery'])) {
    die();
}

$galleryId = $_GET['gallery'];
$gallery = new BlockGallery('gallery' . $galleryId);
$images = Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY), $galleryId);

foreach ($images as $image) {
    $gallery->addImage($image);
}

$gallery->display();