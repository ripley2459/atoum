<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['video'])) {
    die();
}

$video = new Video($_GET['video']);

?>

<div class="layoutVideo">
    <div class="video">
        <?php

        echo $video->display();
        echo '<h1>' . $video->getName() . '</h1>';

        ?>
    </div>
    <div class="underVideo">
        <?php //echo $video->getRelatedMoviesByTags(); ?>
    </div>
    <div class="sideVideo">
        <?php //echo $video->getRelatedMoviesByActors(); ?>
    </div>
</div>