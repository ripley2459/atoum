<?php

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