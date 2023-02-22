<?php

require_once dirname(__DIR__, 2) . '/load.php';

$type = EDataType::GALLERY->value;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$currentPage = $_GET['currentPage'] ?? 1;
$searchFor = RString::EMPTY;

$pagination = new BlockPagination('galleriesPagination', RString::EMPTY, 'number of lines: ', $currentPage, ceil(AContent::getAmount($type) / $limit));
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);
$pagination->addLimitButton(200);
$pagination->addLimitButton(400);

?>

<?= $pagination->display() ?>
<div id="registeredGalleriesPresentation">
    <?php foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage, $searchFor) as $content): ?>
        <div id="gallery<?= $content->getId() ?>" class="gallery" ondrop="addToGallery(event, <?= $content->getId() ?>)" ondragover="allowDrop(event)">
            <button onclick="toggleValueURLParam('focus', <?= $content->getId() ?>);listGalleries();listImages()"><?= $content->getName() ?></button><button onclick="toggleCollapse('images<?= $content->getId() ?>')">Collapse</button>
            <div id="images<?= $content->getId() ?>" class="collapse">
                <?php

                $images = Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY), $content->getId());

                $gallery = new BlockGrid('gallery' . $content->getId());
                $gallery->setColumnCount(3);

                foreach ($images as $image) {
                    $gallery->addElement('<img src="' . UPLOADS_URL . FileHandler::getPath($image) . '" style="max-width:360px">');
                }

                $gallery->display();

                ?>
            </div>
        </div>
    <?php endforeach ?>
</div>