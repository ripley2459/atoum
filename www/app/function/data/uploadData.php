<?php

if (isset($_POST['newFile']))
    Auth::set('fragIndex', 0);

R::require('fragAmount', 'fragIndex');

$blob = $_FILES['file']['tmp_name'];
if (empty($blob)) {
    echo '<h1>Blob is empty!</h1>';
    die;
}

$frag = R::getParameter('fragIndex');
$finalName = R::nextName(FileHandler::getDefaultPath() . R::sanitize($_POST['fileName']));
$fileInfos = R::pathInfo($finalName);

FileHandler::checkPath(FileHandler::getDefaultPath());

if (!move_uploaded_file($blob, $finalName . '_part' . $frag)) {
    unlink($blob);
    echo '<h1>Blob can\'t be moved!</h1>';
    die;
}

Auth::set('fragIndex', Auth::get('fragIndex') + 1);
if (Auth::get('fragIndex') < R::getParameter('fragAmount'))
    return;

for ($x = 1; $x <= Auth::get('fragIndex'); $x++) {
    $tBlob = $finalName . '_part' . $x;
    $fBlob = fopen($tBlob, 'rb');
    $cache = fread($fBlob, 1048576);
    fclose($fBlob);

    $final = fopen($finalName, 'ab');
    $write = fwrite($final, $cache);
    fclose($final);

    unlink($tBlob);
}

$mimeType = mime_content_type($finalName);
if (!R::whitelist($mimeType, FileHandler::ALLOWED_TYPES)) {
    echo '<h1>File type can\'t be validated!</h1>';
    unlink($finalName);
    die;
}

$data = [
    [0], [EDataType::fromMime($mimeType)->value], [0], [$fileInfos['basename']], [$fileInfos['filename']], [R::EMPTY], [0]
];

Content::register($data);