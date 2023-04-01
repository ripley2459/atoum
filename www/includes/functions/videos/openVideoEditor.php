<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['contentId'])) {
    die();
}

$settings = new BlockSettings(EDataType::VIDEO, $_GET['contentId'], 'videoSettings');

$settings->nameSection();
$settings->dateCreated();
$settings->dateModified();
$settings->addLiveSection('tags', EDataType::TAG);

$settings->display();