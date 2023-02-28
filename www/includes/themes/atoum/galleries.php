<?php

require_once dirname(__DIR__, 3) . '/load.php';

$type = EDataType::GALLERY->value;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$currentPage = $_GET['currentPage'] ?? 1;
$searchFor = RString::EMPTY;

$pagination = new BlockPagination('galleriesPagination', RString::EMPTY, 'number of lines: ', $currentPage, ceil(AContent::getAmount($type) / $limit));
$pagination->addLimitButton(5);
$pagination->addLimitButton(15);
$pagination->addLimitButton(30);

$grid = new BlockGrid("registeredGalleriesGrid");

$pagination->display();

foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage, $searchFor) as $content) {
    $grid->addElement('<a href="' . URL . '/index.php?page=viewGallery&gallery=' . $content->getId() . '"/>' . $content->getName() . '</a>');
}

$grid->display();