<?php

require_once dirname(__DIR__, 2) . '/load.php';

if (isset($_GET['childId']) && isset($_GET['parentId']) && isset($_GET['childType']) && isset($_GET['parentType'])) {
    $childId = $_GET['childId'];
    $parentId = $_GET['parentId'];
    $childType = EDataType::fromInt($_GET['childType']);
    $parentType = EDataType::fromInt($_GET['parentType']);

    if (!Relation::relationExists(Relation::getRelationType($childType, $parentType), $childId, $parentId)) {
        $newRelation = new Relation();
        $newRelation->registerInstance(Relation::getRelationType($childType, $parentType), $childId, $parentId);
    }
}