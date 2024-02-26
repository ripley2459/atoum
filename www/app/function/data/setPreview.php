<?php

$content = new Content(R::getParameter('id'));
$image = R::getParameter('image');

list($type, $image) = explode(';', $image);
list(, $image) = explode(',', $image);
$image = base64_decode($image);

$path = FileHandler::getPath($content) . '.png';

file_put_contents($path, $image);