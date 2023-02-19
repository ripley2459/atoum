<?php

require_once dirname(__DIR__, 2) . '/load.php';

if (isset($_GET['aId']) && isset($_GET['bId']) && isset($_GET['aType']) && isset($_GET['bType'])) {
    $aId = $_GET['aId'];
    $bId = $_GET['bId'];
    $aType = EDataType::fromInt($_GET['aType']);
    $bType = EDataType::fromInt($_GET['bType']);

    if (!Relation::relationExists(Relation::getRelationType($aType, $bType), $aId, $bId)) {
        $newRelation = new Relation();
        $newRelation->registerInstance(Relation::getRelationType($aType, $bType), $aId, $bId);
    }
}