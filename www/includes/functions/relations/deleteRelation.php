<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (isset($_GET['childId']) && isset($_GET['parentId']) && isset($_GET['childType']) && isset($_GET['parentType'])) {
    $childId = $_GET['childId'];
    $parentId = $_GET['parentId'];
    $childType = EDataType::from($_GET['childType']);
    $parentType = EDataType::from($_GET['parentType']);
    Relation::getRelation(Relation::getRelationType($childType, $parentType), $childId, $parentId)->unregister();
}