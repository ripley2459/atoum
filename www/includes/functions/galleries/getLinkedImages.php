<?php

require_once dirname(__DIR__, 3) . '/load.php';

$pagination = new BlockPagination('linkedImagesPagination', RString::EMPTY, 'number of images: ', Researcher::Instance()->getCurrentPage(), ceil(AContent::getAmount(Researcher::Instance()->getType()) / Researcher::Instance()->getLimit()), 'getLinkedImages');
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);
$pagination->addLimitButton(200);
$pagination->addLimitButton(400);
$pagination->display();

$grid = new BlockGrid('linkedImagesGrid');
$grid->setColumnCount(3);

$gallery = new Gallery($_GET['gallery']);
foreach (Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY), $gallery->getId()) as $image) {
    $grid->addContent('<img id="linkedImage' . $image->getId() . '" src="' . UPLOADS_URL . FileHandler::getPath($image) . '" draggable="true" ondragstart="bindImage(event, ' . $image->getId() . ')" style="max-width:360px">');
}

?>

<div ondrop="addToGallery(event, <?= $gallery->getId() ?>)" ondragover="allowDrop(event)">
    <?= $grid->display() ?>
</div>