<?php

R::require('id');

$video = new Video($_GET['id']);

$relatedVideosByActors = R::EMPTY;
$rrr = $video->getRelatedFrom(EDataType::VIDEO, EDataType::ACTOR);
shuffle($rrr);
$rrr = array_splice($rrr, 0, 16);
foreach ($rrr as $related) {
    $relatedVideosByActors .= '<div>' . $related->display() . '</div>';
}

$relatedVideosByTags = R::EMPTY;
$rrr = $video->getRelatedFrom(EDataType::VIDEO, EDataType::TAG);
shuffle($rrr);
$rrr = array_splice($rrr, 0, 16);
foreach ($rrr as $related) {
    $relatedVideosByTags .= '<div>' . $related->display() . '</div>';
}



?>

<div class="row">
    <div class="two-thirds column">
        <div id="main-video">
            <?= $video->player() ?>
            <h1><?= $video->getName() ?></h1>
            <div class="row">
                <?= $video->getDateCreatedFormatted() ?>
                <?= $video->getViews() . ' views' ?>
                <button onclick="openEdit(<?= $video->getId() ?>, <?= $video->getType()->value ?>)">Edit</button>
            </div>
        </div>
        <div id="edit"></div>
        <div id="related-videos" class="grid" style="column-count: 4">
            <?= $relatedVideosByTags ?>
        </div>
    </div>
    <div class="one-third column">
        <div id="related-actors" class="grid" style="column-count: 2">
            <?= $relatedVideosByActors ?>
        </div>
    </div>
</div>
