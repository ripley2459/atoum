<?php

require_once dirname(__DIR__, 2) . '/load.php';
R::require('id');

$content = new Content($_GET['id']);

$e = '<div class="grid fake-container" style="column-count: 5" ondrop="linkImage(event, [' . $content->getId() . ',' . EDataType::IMAGE->value . ',' . EDataType::GALLERY->value . '])" ondragover="allowDrop(event)">';
foreach (Relation::getChildren(Relation::getRelationType(EDataType::IMAGE, $content->getType()), $content->getId()) as $img) {
    $e .= '<img id="' . $img->getSlug() . '" src="' . UPLOADS_URL . FileHandler::getPath($img) . '" draggable="true" ondragstart="bindImage(event, ' . $img->getId() . ')"/>';
}
echo $e . '</div>';