<?php

require_once dirname(__DIR__, 2) . '/load.php';
global $DDB;

R::require('type', 'field', 'search');

$r = Request::select(PREFIX . 'contents', 'id', 'type', 'name')
    ->where('type', '=', EDataType::from($_GET['type'])->value)
    ->where('name', 'LIKE', $_GET['search']);

$data = $r->execute();
$contents = array();

?>

<ul>
    <?php while ($d = $data->fetch(PDO::FETCH_ASSOC)) { ?>
        <li><?= Blocks::buttonSearchData($_GET['field'], $d['name']) ?></li>
    <?php } ?>
</ul>