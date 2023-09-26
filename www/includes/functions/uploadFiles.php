<?php

session_start();

require_once dirname(__DIR__, 2) . '/load.php';

if (isset($_POST['newFile'])) $_SESSION['frag'] = 0;

FileHandler::checkDefaultPath();
$blob = $_FILES['file']['tmp_name'];

if (!empty($blob)) {
    $totalChunk = $_POST['chunkAmount'];
    $frag = $_POST['frag'];
    $finalName = FileHandler::getNextFreeName(R::sanitize($_POST['fileName']), FileHandler::getPath());

    if (move_uploaded_file($blob, UPLOADS . $finalName . '_part' . $frag)) {
        $_SESSION['frag']++;

        if ($_SESSION['frag'] >= $totalChunk) {
            $finalFile = FileHandler::createPath($finalName);

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

            $mimeType = mime_content_type($finalFile);
            if (in_array($mimeType, FileHandler::ALLOWED_TYPES)) {
                if (Content::insert(0, EDataType::fromMime($mimeType), $finalName) != null) {
                    Logger::logInfo($_POST['fileName'] . ' has been registered in the database');
                } else {
                    Logger::logError($_POST['fileName'] . ' can\'t be registered in the database!');
                }
            } else {
                Logger::logError('This type of file is not allowed!');
            }
        }
    } else {
        unlink($blob);
    }
} else {
    Logger::logError('File is empty!');
}