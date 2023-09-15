<?php

require_once dirname(__DIR__, 2) . '/load.php';
R::require('childId', 'parentId', 'childType', 'parentType');

$childId = $_GET['childId'];
$parentId = $_GET['parentId'];
$childType = EDataType::from($_GET['childType']);
$parentType = EDataType::from($_GET['parentType']);

if (!Relation::relationExists(Relation::getRelationType($childType, $parentType), $childId, $parentId)) {
    Logger::logInfo(Relation::insert(Relation::getRelationType($childType, $parentType), $childId, $parentId));
}