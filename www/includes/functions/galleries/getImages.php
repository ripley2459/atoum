<?php

require_once dirname(__DIR__, 3) . '/load.php';

$type = $_GET['type'] ?? null;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$searchFor = $_GET['searchFor'] ?? RString::EMPTY;
$currentPage = $_GET['currentPage'] ?? 1;
$totalPages = ceil(AContent::getAmount($type) / $limit);

$pagination = new BlockPagination('imagesPagination', RString::EMPTY, 'number of images: ', $currentPage, $totalPages, 'getImages');
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);
$pagination->addLimitButton(200);
$pagination->addLimitButton(400);
$pagination->display();

$grid = new BlockGrid('imagesGrid');
$grid->setColumnCount(4);

$gallery = new Gallery($_GET['gallery']);
foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage, $searchFor) as $image) {
    $grid->addElement('<img id="image' . $image->getId() . '" src="' . UPLOADS_URL . FileHandler::getPath($image) . '" draggable="true" ondragstart="bindImage(event, ' . $image->getId() . ')" style="max-width:360px">');
}

?>

<div ondrop="removeFromGallery(event, <?= $gallery->getId() ?>)" ondragover="allowDrop(event)">
    <?= $grid->display() ?>
</div>