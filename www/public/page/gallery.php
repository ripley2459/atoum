<?php

$galleryId = R::getParameter('gallery');
if ($galleryId == 'random') {
    $data = RDB::select('contents', 'id')
        ->where('type', '=', EDataType::IMAGE->value)
        ->limit(100)
        ->orderBy('id', 'RAND()')
        ->execute();
    $images = array();
    while ($d = $data->fetch(PDO::FETCH_ASSOC))
        $images[] = new Content($d['id']);
    App::setTitle('Atoum - Random Gallery');
    App::setDescription('Atoum - Random Gallery');
    galleryFromImages('random', $images);
} else {
    $data = new Content($galleryId);
    App::setTitle('Atoum - ' . $data->getName());
    App::setDescription($data->getName());
    galleryFromContent($data);
    dataInfo($data);
}