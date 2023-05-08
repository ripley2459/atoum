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

$tags = RString::EMPTY;
$actors = RString::EMPTY;

foreach ($video->getRelated(EDataType::ACTOR, true) as $actor) {
    RString::concat($actors, RString::EMPTY, chipActor($actor));
}

foreach ($video->getRelated(EDataType::TAG, true) as $tag) {
    RString::concat($tags, RString::EMPTY, chipTag($tag));
}

?>

<div class="layoutVideo">
    <div class="video">
        <?= $video->display() ?>
        <div id="videoInfos">
            <h1><?= $video->getName() ?></h1>
            <div class="chipsContainer">
                <div class="chips actors"><?= $tags ?></div>
                <div class="chips tags"><?= $actors ?></div>
            </div>
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