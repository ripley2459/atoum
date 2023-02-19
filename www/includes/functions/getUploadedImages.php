<?php

require_once dirname(__DIR__, 2) . '/load.php';

$type = $_GET['type'] ?? null;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$searchFor = $_GET['searchFor'] ?? RString::EMPTY;
$currentPage = $_GET['currentPage'] ?? 1;
$totalPages = ceil(AContent::getAmount($type) / $limit);

$pagination = new BlockPagination('imagesPagination', RString::EMPTY, 'number of lines: ', $currentPage, $totalPages, 'listImages');
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);
$pagination->addLimitButton(200);
$pagination->addLimitButton(400);

$gallery = new BlockGrid('registeredImagesGrid');
$gallery->setColumnCount(3);
$pagination->display();

foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage, $searchFor) as $content) {
    $gallery->addElement('<img id="draggableImage' . $content->getId() .'" src="' . UPLOADS_URL . FileHandler::getPath($content) . '" draggable="true" ondragstart="bindImage(event, ' . $content->getId() .')" style="max-width:360px">');
}

$gallery->display();
