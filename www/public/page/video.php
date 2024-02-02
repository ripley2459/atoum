<?php

$data = new Content(R::getParameter('video'));

App::setTitle('Atoum - ' . $data->getName());
App::setDescription($data->getName());

videoPlayer($data);
dataInfo($data);

?>

<div id="<?= $data->getId() ?>-related-container" class="related-container">
    <div class="row">
        <div class="six columns">
            <h3>Related by tags</h3>
            <div class="masonry">
                <?php foreach (Relation::getRelatedStepped($data, EDataType::TAG, EDataType::VIDEO, 16) as $sub)
                    videoLinkWithPoster($sub); ?>
            </div>
        </div>
        <div class="six columns">
            <h3>Related by actors</h3>
            <div class="masonry">
                <?php foreach (Relation::getRelatedStepped($data, EDataType::ACTOR, EDataType::VIDEO, 16) as $sub)
                    videoLinkWithPoster($sub); ?>
            </div>
        </div>
    </div>
</div>