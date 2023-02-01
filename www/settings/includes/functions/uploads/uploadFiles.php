<?php

session_start();

require_once dirname(__DIR__, 4) . '/load.php';

if (isset($_POST['newFile'])) {
    Logger::logInfo('New file upload ope');
    $_SESSION['frag'] = 0;
}

$blob = $_FILES['file']['tmp_name'];

if (!empty($blob)) {
    $totalChunk = $_POST['chunkAmount'];
    $frag = $_POST['frag'];

    $finalName = lightNormalize($_POST['fileName']);
    $finalFile = FileHandler::getPathForFile($_POST['fileName']);

    FileHandler::checkDefaultPath();

    if (move_uploaded_file($blob, UPLOADS . $finalName . '_part' . $frag)) {
        $_SESSION['frag']++;

        Logger::logInfo('Receiving blob ' . $_SESSION['frag'] . '/' . $totalChunk);

        if ($_SESSION['frag'] >= $totalChunk) {
            Logger::logInfo('Blobs are uploaded, will be merged');

            for ($x = 1; $x <= $_SESSION['frag']; $x++) {
                $tBlob = UPLOADS . $finalName . '_part' . $x;
                $fBlob = fopen($tBlob, 'rb');
                $cache = fread($fBlob, 1048576);
                fclose($fBlob);

                $final = fopen($finalFile, 'ab');
                $write = fwrite($final, $cache);
                fclose($final);

                unlink($tBlob);
            }

            Logger::logInfo('Blobs merged');
        } else {
            Logger::logInfo('Waiting gor the rest of the file ' . $_SESSION['frag'] . '/' . $totalChunk);
        }
    } else {
        unlink($blob);
        Logger::logError('Can\'t move the blob to its destination');
    }
} else {
    Logger::logError('File is empty');
}