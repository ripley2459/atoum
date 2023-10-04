<?php

global $DDB;
R::require('id');

$gallery = new BlockGallery('gallery-' . $_GET['id']);
if ($_GET['id'] == 'random') {
    $s = 'SELECT id FROM ' . PREFIX . 'contents WHERE type = :type ORDER BY RAND() LIMIT 100';
    $r = $DDB->prepare($s);
    $r->bindValue(':type', EDataType::IMAGE->value, PDO::PARAM_INT);
    $r->execute();

    $images = array();
    while ($d = $r->fetch(PDO::FETCH_ASSOC)) {
        $gallery->addImage(new Image($d['id']));
    }
} else {
    $gallery->getImages($_GET['id'], true);
}


echo $gallery->display();