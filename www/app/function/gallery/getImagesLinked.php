<?php

$content = new Content(R::getParameter('data'));

foreach (Relation::getRelated($content, EDataType::IMAGE) as $image) { ?>
    <button class="image-button" onclick="unlinkImage(this,<?= $image->getId() ?>)">
        <?php image($image) ?>
    </button>
<?php } ?>