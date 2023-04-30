<?php

require_once dirname(__DIR__, 3) . '/load.php';
global $DDB;

if (!isset($_POST['id']) || !isset($_POST['type']) || !isset($_POST['name'])) {
    die;
}

$parent = AContent::createInstance(EDataType::from($_POST['type']), $_POST['id']);

if (isset($_POST['sections'])) {
    foreach (array_unique($_POST['sections']) as $section) {
        $sectionName = str_replace('[]', '', $section);

        try {
            $type = EDataType::fromName($sectionName);
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }

        Relation::purgeFor(Relation::getRelationType($type, $parent->getType()), $parent->getId());

        $s = 'SELECT id FROM ' . PREFIX . 'contents WHERE name = :name';
        $r = $DDB->prepare($s);

        foreach (array_unique($_POST[$sectionName]) as $input) {
            $r->bindValue(':name', $input, PDO::PARAM_STR);
            $r->execute();

            try {
                if ($r->rowCount() > 0) {
                    $d = $r->fetch();
                    $data = AContent::createInstance($type, $d['id']);
                } else {
                    $data = AContent::createInstance($type);
                    if (!$data->registerInstance(0, $type, EDataStatus::PUBLISHED, 0, lightNormalize($input), $input, "null", 0)) {
                        echo 'A non blocking error has occurred: ' . $input;
                        break;
                    }
                }
            } catch (Exception $e) {
                echo 'An error has occurred!';
                break;
            }

            $relation = new Relation();
            $relation->registerInstance(Relation::getRelationType($type, $parent->getType()), $data->getId(), $parent->getId());
        }

        $r->closeCursor();
    }
}