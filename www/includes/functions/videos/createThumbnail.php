<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['videoId']) || !isset($_POST['image'])) {
    die();
}

$video = new Video($_GET['videoId']);

$data = $_POST['image'];
list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);
$data = base64_decode($data);

$path = UPLOADS . FileHandler::getPath($video) . '.png';

file_put_contents($path, $data);