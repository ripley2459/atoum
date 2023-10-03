<?php

require_once dirname(__DIR__, 2) . '/load.php';

R::require('id', 'image');

$video = new Video($_POST['id']);
$image = $_POST['image'];

list($type, $image) = explode(';', $image);
list(, $image) = explode(',', $image);
$image = base64_decode($image);

$path = UPLOADS . FileHandler::getPath($video) . '.png';

file_put_contents($path, $image);