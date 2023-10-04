<?php

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    echo 'Warning, can\'t get the form.';
    die();
}

try {
    $data = AContent::createInstance(EDataType::from($_GET['type']), $_GET['id']);
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

$settings = BlockSettings::base($data);
echo $settings->display();