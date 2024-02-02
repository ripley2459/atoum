<?php

$content = new Content(R::getParameter('data'));

foreach (Relation::getRelated($content, EDataType::VIDEO) as $video) { ?>
    <button class="video-button" onclick="unlinkVideo(this,<?= $video->getId() ?>)">
        <?php echo videoPoster($video, true) ?>
    </button>
<?php } ?>