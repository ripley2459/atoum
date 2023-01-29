<?php

require_once dirname(__DIR__, 4) . '/load.php';

Logger::clear();

if (!isset($_FILES['files'])) {
    Logger::logError('The request to uploads files is null');
    return;
}

if (empty($_FILES['files'])) {
    Logger::logError('The request to uploads files is empty');
    return;
}

try {
    Logger::logInfo();
    echo FileHandler::uploadFiles($_FILES['files']);
} catch (Exception $e) {
    Logger::logError($e->getMessage());
}