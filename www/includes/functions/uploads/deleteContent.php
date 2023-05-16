<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die;
}

$dataId = $_GET['id'];
$dataType = EDatatype::from($_GET['type']);
$content = AContent::createInstance($dataType, $dataId);

foreach (EDataType::cases() as $type) {
    try {
        Relation::purgeFor(Relation::getRelationType($type, $dataType), $dataId);
        Relation::purgeFor(Relation::getRelationType($dataType, $type), $dataId);
    } catch (Exception $e) {
        Logger::logError($e);
    }
}

$content->unregister();