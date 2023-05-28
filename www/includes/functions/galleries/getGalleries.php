<?php

require_once dirname(__DIR__, 3) . '/load.php';

Researcher::Instance()->setType(EDataType::GALLERY);
Researcher::Instance()->setStatus(null);
Researcher::Instance()->setOrderBy(null);

$pagination = new BlockPagination('galleriesPagination', RString::EMPTY, 'number of lines: ', Researcher::Instance()->getCurrentPage(), ceil(AContent::getAmount(Researcher::Instance()->getType()) / Researcher::Instance()->getLimit()));
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);

$grid = new BlockGrid("registeredGalleriesGrid");

$pagination->display();

foreach (AContent::getAll(Researcher::Instance()->getType(), Researcher::Instance()->getStatus(), Researcher::Instance()->getOrderBy(), Researcher::Instance()->getLimit(), Researcher::Instance()->getCurrentPage(), Researcher::Instance()->getSearchFor()) as $content) {
    $grid->addContent('<a href="' . URL . '/settings/index.php?page=editorGallery&gallery=' . $content->getId() . '"/>' . $content->getName() . '</a>');
}

echo $grid->display();