<?php

session_start();

require_once dirname(__DIR__, 2) . '/load.php';

if (isset($_POST['newFile'])) {
    Logger::clear();
    $_SESSION['frag'] = 0;
}

FileHandler::checkDefaultPath();
$blob = $_FILES['file']['tmp_name'];

if (!empty($blob)) {
    $totalChunk = $_POST['chunkAmount'];
    $frag = $_POST['frag'];
    $finalName = FileHandler::getNextFreeName(lightNormalize($_POST['fileName']), FileHandler::getPath());

    if (move_uploaded_file($blob, UPLOADS . $finalName . '_part' . $frag)) {
        $_SESSION['frag']++;

        if ($_SESSION['frag'] >= $totalChunk) {
            $finalFile = FileHandler::getPathForFile($finalName);

            for ($x = 1; $x <= $_SESSION['frag']; $x++) {
                $tBlob = UPLOADS . $finalName . '_part' . $x;
                $fBlob = fopen($tBlob, 'rb');
                $cache = fread($fBlob, 1048576);
                fclose($fBlob);

                $final = fopen($finalFile, 'ab');
                $write = fwrite($final, $cache);
                fclose($final);

                unlink($tBlob);
            } // Jusque là c'est ok

            $mimeType = mime_content_type($finalFile);
            if (in_array($mimeType, FileHandler::ALLOWED_TYPES)) {
                $instance = AContent::createInstance(EDataType::fromMime($mimeType));
                if ($instance->registerInstance(0,
                    EDataType::fromMime($mimeType)->value,
                    EDataStatus::PUBLISHED->value,
                    0,
                    $finalName,
                    $_POST['fileName'],
                    'null',
                    0)
                ) {
                    Logger::logInfo($_POST['fileName'] . ' has been registered in the database');
                }
            } else {
                Logger::logError('This type of file is not allowed');
                // TODO supprimer le fichier ?
            }
        }
    } else {
        unlink($blob);
    }
} else {
    Logger::logError('File is empty');
}