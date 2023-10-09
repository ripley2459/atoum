<?php

R::require('id');

$video = new Video($_GET['id']);

$byActors = R::EMPTY;
$rrr = $video->getRelatedFrom(EDataType::VIDEO, EDataType::ACTOR);
shuffle($rrr);
$rrr = array_splice($rrr, 0, 16);
foreach ($rrr as $related) {
    R::append($byActors, R::EMPTY, '<div>' . $related->display() . '</div>');
}

$byTags = R::EMPTY;
$rrr = $video->getRelatedFrom(EDataType::VIDEO, EDataType::TAG);
shuffle($rrr);
$rrr = array_splice($rrr, 0, 16);
foreach ($rrr as $related) {
    R::append($byTags, R::EMPTY, '<div>' . $related->display() . '</div>');
}

$actors = R::EMPTY;
foreach ($video->getRelated(EDataType::ACTOR) as $actor) {
    R::append($actors, R::SPACE, Blocks::chipTag($actor));
}
$tags = R::EMPTY;
foreach ($video->getRelated(EDataType::TAG) as $tag) {
    R::append($tags, R::SPACE, Blocks::chipTag($tag));
}

$video->increaseViews();

?>

<div class="row">
    <div class="two-thirds column">
        <div id="main-video">
            <?= $video->player() ?>
            <div class="row">
                <h1><?= $video->getName() ?></h1>
            </div>
            <div class="row">
                <div class="six columns">
                    <?= $actors ?>
                </div>
                <div class="six columns">
                    <?= $tags ?>
                </div>
            </div>
            <div class="row">
                <div class="four columns">
                    <?= $video->getDateCreatedFormatted() ?>
                </div>
                <div class="four columns">
                    <?= $video->getViews() . ' views' ?>
                </div>
                <div class="four columns">
                    <button onclick="openEdit(<?= $video->getId() ?>, <?= $video->getType()->value ?>)">Edit</button>
                </div>
            </div>
        </div>
        <div id="edit"></div>
        <div id="related-videos" class="grid" style="column-count: 4">
            <?= $byTags ?>
        </div>
    </div>
    <div class="one-third column">
        <div id="related-actors" class="grid" style="column-count: 2">
            <?= $byActors ?>
        </div>
    </div>
</div>