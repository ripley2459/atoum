<?php

require_once dirname(__DIR__, 2) . '/load.php';
R::require('childId', 'parentId', 'childType', 'parentType');
global $DDB;

$childId = $_GET['childId'];
$parentId = $_GET['parentId'];
$childType = EDataType::from($_GET['childType']);
$parentType = EDataType::from($_GET['parentType']);

$s = 'DELETE FROM ' . PREFIX . 'relations WHERE type = :type AND child = :child AND parent = :parent';
$r = $DDB->prepare($s);
$r->bindValue(':type', Relation::getRelationType($childType, $parentType), PDO::PARAM_INT);
$r->bindValue(':child', $childId, PDO::PARAM_INT);
$r->bindValue(':parent', $parentId, PDO::PARAM_INT);
$r->execute();
$r->closeCursor();

