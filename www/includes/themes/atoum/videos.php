<?php

require_once dirname(__DIR__, 3) . '/load.php';

$type = EDataType::VIDEO->value;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 25;
$currentPage = $_GET['currentPage'] ?? 1;
$searchFor = RString::EMPTY;

$pagination = new BlockPagination('videosPagination', RString::EMPTY, 'number of lines: ', $currentPage, ceil(AContent::getAmount($type) / $limit));
//$pagination->addLimitButton(5);
//$pagination->addLimitButton(15);
//$pagination->addLimitButton(30);

$grid = new BlockGrid("registeredVideosGrid");

foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage, $searchFor) as $content) {
    $grid->addElement('<div class="video">' . $content->displayLink() . '<span class="videoName">' . $content->getName() . '</span></a></div>');
}

$grid->display();
$pagination->display();