<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['contentId'])) {
    die();
}

$data = new Video($_GET['contentId']);
$settings = BlockSettings::base($data);
$settings->screenshotButton();
echo $settings->display();