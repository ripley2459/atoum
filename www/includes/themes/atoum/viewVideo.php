<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['video'])) {
    die();
}

global $DDB;
$video = new Video($_GET['video']);
$relatedActors = new BlockGrid('relatedActors');
foreach ($video->getRelatedFrom(EDataType::VIDEO, EDataType::ACTOR) as $related) {
    $relatedActors->addElement($related->displayLink());
}
$relatedActors->setColumnCount(2);

$relatedVideos = new BlockGrid('relatedVideos');
foreach ($video->getRelatedFrom(EDataType::VIDEO, EDataType::TAG) as $related) {
    $relatedVideos->addElement($related->displayLink());
}
$relatedVideos->setColumnCount(4);

?>

<div class="layoutVideo">
    <div class="video">
        <?= $video->display() ?>
        <div id="videoInfos">
            <h1><?= $video->getName() ?></h1>
            <button onclick="getContent('<?= FUNCTIONS_URL ?>videos/openVideoEditor.php', 'videoInfos', <?= $video->getId() ?>)">Edit</button>
        </div>
    </div>
    <div class="underVideo">
        <?php $relatedVideos->display() ?>
    </div>
    <div class="sideVideo">
        <?php $relatedActors->display() ?>
    </div>
</div>