<?php

$data = new Content(R::getParameter('actor'));

App::setTitle('Atoum - ' . $data->getName());
App::setDescription('Atoum - ' . $data->getName()); ?>

<div id="<?= $data->getId() ?>-data-container" class="data-container">
    <section>
        <h1><?= $data->getName() ?></h1>
    </section>
    <section class="u-space-top">
        <h3>Tags</h3>
        <div class="tags list">
            <?php
            $tags = array();
            foreach (Relation::getRelated($data, EDataType::TAG) as $sub)
                $tags[] = $sub;
            $tags = array_unique($tags);
            foreach ($tags as $sub) { ?>
                <a href="#" class="button light"><?= $sub->getName() ?></a>
            <?php } ?>
        </div>
    </section>
    <section class="u-space-top">
        <h3>Settings</h3>
        <div class="settings list">
            <a class="button light" href="<?= App::getLink('edit', 'data=' . $data->getId()) ?>" target="_blank">Edit</a>
        </div>
    </section>
</div>

<div id="<?= $data->getId() ?>-related-container" class="related-container">
    <h3>Related videos</h3>
    <div class="masonry" style="column-count: 6">
        <?php foreach (Relation::getRelated($data, EDataType::VIDEO, false) as $sub)
            videoLinkWithPoster($sub); ?>
    </div>
</div>