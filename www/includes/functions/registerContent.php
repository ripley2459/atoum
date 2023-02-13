<?php

require_once dirname(__DIR__, 2) . '/load.php';

if (!isset($_GET['type']) || !isset($_GET['name'])) {
    return;
}

$type = EContentType::fromInt($_GET['type']);
$name = $_GET['name'];
$slug = lightNormalize($name);

Logger::logInfo($slug);

$newInstance = AContent::createInstance($type);
if ($newInstance->registerInstance(0, $type->value, EContentStatus::PUBLISHED->value, 0, $slug, $name, 'null', 0)) {
    Logger::logInfo($_POST['fileName'] . ' has been registered in the database');
}