<?php

require_once dirname(__DIR__, 3) . '/load.php';
global $DDB;

if (!isset($_GET['type']) || !isset($_GET['field']) || nullOrEmpty($_GET['search'])) {
    die;
}

$type = EDataType::from($_GET['type']);
$field = $_GET['field'];
$search = $_GET['search'];

$s = 'SELECT id, type FROM ' . PREFIX . 'contents WHERE type = :type AND name LIKE :search';
$r = $DDB->prepare($s);

$r->bindValue(':type', $type->value, PDO::PARAM_INT);
$r->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

try {
    $r->execute();

    while ($d = $r->fetch(PDO::FETCH_ASSOC)) {
        $data = AContent::createInstance(EDataType::from($d['type']), $d['id']);
        echo '<button type="button" onclick="DynDataAddOnClick(\'' . $data->getName() . '\', ' . $type->value . ', \'' . $field . '[]\')">' . $data->getName() . '</button>';
    }

    $r->closeCursor();
} catch (PDOException $e) {
    echo $e->getMessage();
} catch (Exception $p) {
    echo $p->getMessage();
}