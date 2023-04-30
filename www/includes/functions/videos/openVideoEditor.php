<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['contentId'])) {
    die();
}

$video = new Video($_GET['contentId']);
$settings = new BlockSettings($video->getType(), $video->getId(), 'videoSettings');

$settings->nameSection();
$settings->dateCreated();
$settings->dateModified();
$settings->liveSection('Add actors', EDataType::ACTOR);
$settings->liveSection('Add tags', EDataType::TAG);

$settings->display();