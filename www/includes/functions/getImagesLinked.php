<?php

require_once dirname(__DIR__, 2) . '/load.php';
R::require('id');

$content = new Content($_GET['id']);

foreach (Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, $content->getType()), $content->getId()) as $img) { ?>
    <button class="image-button" onclick="unlinkImage(this,<?= $img->getId() ?>,[<?= $content->getId() ?>,<?= EDataType::IMAGE->value ?>,<?= EDataType::GALLERY->value ?>])">
        <img src="<?= UPLOADS_URL . FileHandler::getPath($img) ?>"/>
    </button>
<?php } ?>