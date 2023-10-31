<?php

global $DDB;
R::require('id');

$gallery = new Content($_GET['id']);
$block = new BlockGallery('gallery-' . $gallery->getId());

if ($_GET['id'] == 'random') {
    $s = 'SELECT id FROM ' . PREFIX . 'contents WHERE type = :type ORDER BY RAND() LIMIT 100';
    $r = $DDB->prepare($s);
    $r->bindValue(':type', EDataType::IMAGE->value, PDO::PARAM_INT);
    $r->execute();

    $images = array();
    while ($d = $r->fetch(PDO::FETCH_ASSOC)) {
        $block->addImage(new Image($d['id']));
    }
} else $block->getImages($gallery, true);

echo $block->display();
$gallery->increaseViews();