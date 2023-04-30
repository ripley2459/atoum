<?php

require_once dirname(__DIR__, 3) . '/load.php';

$type = EDataType::GALLERY->value;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 25;
$currentPage = $_GET['currentPage'] ?? 1;
$searchFor = RString::EMPTY;

$pagination = new BlockPagination('galleriesPagination', RString::EMPTY, 'number of lines: ', $currentPage, ceil(AContent::getAmount($type) / $limit));
//$pagination->addLimitButton(5);
//$pagination->addLimitButton(15);
//$pagination->addLimitButton(30);

$grid = new BlockGrid("registeredGalleriesGrid");
$grid->setColumnCount(5);

foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage, $searchFor) as $content) {

    /* TODO OVERKILL TO REFACTO */
    $images = Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY), $content->getId());
    shuffle($images);
    $preview = '<img src="' . UPLOADS_URL . FileHandler::getPath($images[0]) . '">';

    $grid->addElement('<div class="gallery"><a href="' . URL . '/index.php?page=viewGallery&gallery=' . $content->getId() . '"/>' . $preview . '<span class="galleryName">' . $content->getName() . '</span></a></div>');
}

$grid->display();
$pagination->display();