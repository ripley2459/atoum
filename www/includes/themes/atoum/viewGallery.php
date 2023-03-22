<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['gallery'])) {
    die();
}

$galleryId = $_GET['gallery'];
$random = isset($_GET['random']);
$gallery = new BlockGallery('gallery' . $galleryId);
$gallery->setColumnCount(5);
$images = Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY), $galleryId);

if ($random) shuffle($images);

foreach ($images as $image) {
    $gallery->addImage($image);
}

$gallery->display();