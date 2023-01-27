<?php

require_once dirname(__DIR__, 4) . '/load.php';

if (!isset($_FILES['files'])) return;

if (empty($_FILES['files'])) return;

try {
    echo FileHandler::uploadFiles($_FILES['files']);
} catch (Exception $e) {
    Logger::logError($e->getMessage());
}