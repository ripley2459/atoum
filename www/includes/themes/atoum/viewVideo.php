<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['video'])) {
    die();
}

$videoId = $_GET['video'];
$video = new Video($videoId);

$video->display();