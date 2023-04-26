<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['type']) || !isset($_GET['name'])) {
    return;
}

$type = EDataType::fromInt($_GET['type']);
$name = $_GET['name'];
$slug = lightNormalize($name);

$newInstance = AContent::createInstance($type);
if ($newInstance->registerInstance(0, $type, EDataStatus::PUBLISHED, 0, $slug, $name, 'null', 0)) {
    Logger::logInfo($_POST['fileName'] . ' has been registered in the database');
}