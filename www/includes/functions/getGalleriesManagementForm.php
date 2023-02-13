<?php

require_once dirname(__DIR__, 2) . '/load.php';

$type = EContentType::GALLERY->value;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$currentPage = $_GET['currentPage'] ?? 1;

$pagination = new BlockPagination('galleriesPagination', 'number of lines: ', $currentPage, ceil(AContent::getAmount($type) / $limit));
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);
$pagination->addLimitButton(200);
$pagination->addLimitButton(400);

?>

<?= $pagination->display() ?>
<div id="registeredGalleries">
    <?php foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage) as $content): ?>
        <div id="<?= $content->getId() ?>" class="galleryFolder">
            <h3><?= $content->getName() ?></h3>
        </div>
    <?php endforeach ?>
</div>