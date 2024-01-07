<?php

$video = new Content(R::getParameter('video'));

?>
<div class="container">
    <div class="row">
        <div class="two-thirds column">
            <div id="main-video">
                <?php videoPlayer($video) ?>
                <?php videoInfos($video) ?>
            </div>
            <div id="related-videos" class="grid" style="column-count: 4">
                <?php videoRelatedBy($video,EDataType::TAG, 16) ?>
            </div>
        </div>
        <div class="one-third column">
            <div id="related-actors" class="grid" style="column-count: 2">
                <?php videoRelatedBy($video,EDataType::ACTOR, 16) ?>
            </div>
        </div>
    </div>
</div>
