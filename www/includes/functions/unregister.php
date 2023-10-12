<?php

require_once dirname(__DIR__, 2) . '/load.php';
R::require('id');

$content = Content::get($_GET['id'], EDataType::from($_GET['type'] ?? 0));
$content->unregister();