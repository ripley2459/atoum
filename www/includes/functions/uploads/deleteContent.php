<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die;
}

$id = $_GET['id'];
$type = EDatatype::from($_GET['type']);
$content = AContent::createInstance($type, $id);
$content->unregister();
