<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['video'])) {
    die();
}

global $DDB;
$video = new Video($_GET['video']);
$relatedVideosByActors = new BlockGrid('relatedActors');
$rrr = $video->getRelatedFrom(EDataType::VIDEO, EDataType::ACTOR);
shuffle($rrr);
$rrr = array_splice($rrr, 0, 8);
foreach ($rrr as $related) {
    $relatedVideosByActors->addElement('<div>' . $related->displayLink() . '</div>');
}
$relatedVideosByActors->setColumnCount(2);

$relatedVideosByTags = new BlockGrid('relatedVideos');
$rrr = $video->getRelatedFrom(EDataType::VIDEO, EDataType::TAG);
shuffle($rrr);
$rrr = array_splice($rrr, 0, 16);
foreach ($rrr as $related) {
    $relatedVideosByTags->addElement('<div>' . $related->displayLink() . '</div>');
}
$relatedVideosByTags->setColumnCount(4);

$relatedActors = RString::EMPTY;
foreach ($video->getRelated(EDataType::ACTOR) as $actor) {
    $relatedActors .= $actor->display();
}
$relatedTags = RString::EMPTY;
foreach ($video->getRelated(EDataType::TAG) as $tag) {
    $relatedTags .= $tag->display();
}

?>

<div class="layoutVideo">
    <div class="video">
        <?= $video->display() ?>
        <div id="videoInfos">
            <h1><?= $video->getName() ?></h1>
            <div id="videoActors"><?= $relatedTags ?></div>
            <div id="videoTags"><?= $relatedActors ?></div>
            <button onclick="getContent('<?= FUNCTIONS_URL ?>videos/openVideoEditor.php', 'videoInfos', <?= $video->getId() ?>)">Edit</button>
        </div>
    </div>
    <div class="underVideo">
        <?php $relatedVideosByTags->display() ?>
    </div>
    <div class="sideVideo">
        <?php $relatedVideosByActors->display() ?>
    </div>
</div>