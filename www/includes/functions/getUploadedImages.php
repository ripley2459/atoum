<?php

require_once dirname(__DIR__, 2) . '/load.php';

$type = $_GET['type'] ?? null;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$currentPage = $_GET['currentPage'] ?? 1;
$totalPages = ceil(AContent::getAmount($type) / $limit);

$pagination = new BlockPagination('imagesPagination', RString::EMPTY, 'number of lines: ', $currentPage, $totalPages, 'listImages');
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);
$pagination->addLimitButton(200);
$pagination->addLimitButton(400);

$gallery = new BlockGrid('uploadImages');
$gallery->setColumnCount(3);
$pagination->display();

foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage) as $content) {
    $gallery->addElement('<img src="' . UPLOADS_URL . FileHandler::getPath($content) . '">');
}

$gallery->display();
