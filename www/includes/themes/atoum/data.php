<h1>Data</h1>

<?php

$reseach = new BlockReseacher();

$reseach->searchSection();
$reseach->buttonSection(EDataType::GALLERY, EDataType::VIDEO);
$reseach->liveSection('With tags', EDataType::TAG);
$reseach->liveSection('With actors', EDataType::ACTOR);

echo $reseach->display();

/*

require_once dirname(__DIR__, 3) . '/load.php';

Researcher::Instance()->setType(EDataType::VIDEO);
Researcher::Instance()->setStatus(EDataStatus::PUBLISHED);
Researcher::Instance()->setOrderBy("dateCreated_DESC");

$pagination = new BlockPagination('contentPagination', RString::EMPTY, 'number of lines: ', Researcher::Instance()->getCurrentPage(), Researcher::Instance()->getTotalPages(), 'listFiles');
$pagination->addLimitButton(5);
$pagination->addLimitButton(20);
$pagination->addLimitButton(100);
$pagination->addLimitButton(150);
$pagination->addLimitButton(200);

$grid = new BlockGrid("registeredVideosGrid");

foreach (AContent::getAll(Researcher::Instance()->getType(), Researcher::Instance()->getStatus(), Researcher::Instance()->getOrderBy(), Researcher::Instance()->getLimit(), Researcher::Instance()->getCurrentPage(), Researcher::Instance()->getSearchFor()) as $content) {
    $grid->addContent('<div class="video">' . $content->displayLink() . '<span class="videoName">' . $content->getName() . '</span></a></div>');
}

echo $pagination->display();
echo $grid->display();

require_once dirname(__DIR__, 3) . '/load.php';

Researcher::Instance()->setType(EDataType::GALLERY);
Researcher::Instance()->setStatus(EDataStatus::PUBLISHED);
Researcher::Instance()->setOrderBy("dateCreated_DESC");

$pagination = new BlockPagination('galleriesPagination', RString::EMPTY, 'number of lines: ', Researcher::Instance()->getCurrentPage(), ceil(AContent::getAmount(Researcher::Instance()->getType()) / Researcher::Instance()->getLimit()));
$grid = new BlockGrid("registeredGalleriesGrid");
$grid->setColumnCount(5);

foreach (AContent::getAll(Researcher::Instance()->getType(), Researcher::Instance()->getStatus(), Researcher::Instance()->getOrderBy(), Researcher::Instance()->getLimit(), Researcher::Instance()->getCurrentPage(), Researcher::Instance()->getSearchFor()) as $content) {
    $images = Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY), $content->getId());
    shuffle($images);
    $preview = '<img src="' . UPLOADS_URL . FileHandler::getPath($images[0]) . '">';

    $grid->addContent('<div class="gallery"><a href="' . URL . '/index.php?page=viewGallery&gallery=' . $content->getId() . '"/>' . $preview . '<span class="galleryName">' . $content->getName() . '</span></a></div>');
}

echo $grid->display();
echo $pagination->display();

*/