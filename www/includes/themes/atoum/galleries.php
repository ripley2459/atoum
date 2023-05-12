<?php

require_once dirname(__DIR__, 3) . '/load.php';

Researcher::Instance()->setType(EDataType::GALLERY);
Researcher::Instance()->setStatus(EDataStatus::PUBLISHED);
Researcher::Instance()->setOrderBy("dateCreated_DESC");

$pagination = new BlockPagination('galleriesPagination', RString::EMPTY, 'number of lines: ', Researcher::Instance()->getCurrentPage(), ceil(AContent::getAmount(Researcher::Instance()->getType()) / Researcher::Instance()->getLimit()));
$grid = new BlockGrid("registeredGalleriesGrid");
$grid->setColumnCount(5);

foreach (AContent::getAll(Researcher::Instance()->getType(), Researcher::Instance()->getStatus(), Researcher::Instance()->getOrderBy(), Researcher::Instance()->getLimit(), Researcher::Instance()->getCurrentPage(), Researcher::Instance()->getSearchFor()) as $content) {

    /* TODO OVERKILL TO REFACTO */
    $images = Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY), $content->getId());
    shuffle($images);
    $preview = '<img src="' . UPLOADS_URL . FileHandler::getPath($images[0]) . '">';

    $grid->addContent('<div class="gallery"><a href="' . URL . '/index.php?page=viewGallery&gallery=' . $content->getId() . '"/>' . $preview . '<span class="galleryName">' . $content->getName() . '</span></a></div>');
}

echo $grid->display();
echo $pagination->display();