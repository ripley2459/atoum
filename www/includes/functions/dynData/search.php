<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (isset($_GET['type']) && isset($_GET['search'])) {
    $type = EDataType::fromInt($_GET['type']);
    $search = $_GET['search'];

    foreach (AContent::getAll($type->value, EDataStatus::PUBLISHED->value, null, PHP_INT_MAX, null, $search) as $content) {
        Logger::logInfo($content->getName());
        echo '<p>' . $content->getName() . '</p>';
    }
}