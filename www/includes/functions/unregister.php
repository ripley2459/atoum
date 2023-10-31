<?php

require_once dirname(__DIR__, 2) . '/load.php';
R::require('id', 'type');

$content = Content::get($_GET['id'], EDataType::from($_GET['type'] ?? 0));

/*
Logger::clear();
try {
    Relation::obliterate($content);
} catch (Exception $e) {
    Logger::logError($e);
}*/

$content->unregister();