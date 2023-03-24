<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['video'])) {
    die();
}

$video = new Video($_GET['video']);

?>

<div class="layoutVideo">
    <div class="video">
        <?= '<video id="movie' . $video->getId() . '" src="' . UPLOADS_URL . FileHandler::getPath($video) . '" controls></video>' ?>
        <div id="videoInfos">
            <h1><?= $video->getName() ?></h1>
            <button onclick="getContent('<?= FUNCTIONS_URL ?>videos/openVideoEditor.php', 'videoInfos', <?= $video->getId() ?>)">Edit</button>
        </div>
    </div>
    <div class="underVideo">
        <?php //echo $video->getRelatedMoviesByTags(); ?>
    </div>
    <div class="sideVideo">
        <?php //echo $video->getRelatedMoviesByActors(); ?>
    </div>
</div>