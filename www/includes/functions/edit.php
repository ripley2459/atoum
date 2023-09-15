<?php

require_once dirname(__DIR__, 2) . '/load.php';
R::require('id', 'name', 'date', 'views', 'sections');
global $DDB;

$content = new Content($_POST['id']);

$s = 'SELECT id FROM ' . PREFIX . 'contents WHERE name = :name AND type = :type';
$r = $DDB->prepare($s);

foreach (array_unique($_POST['sections']) as $section) {
    try {
        $type = EDataType::fromName($section);
        $relationType = Relation::getRelationType($type, $content->getType());
    } catch (Exception $e) {
        echo $e->getMessage();
        die;
    }

    Relation::purgeFor($relationType, $content->getId());

    if (!isset($_POST[$section])) {
        continue;
    }

    foreach (array_unique($_POST[$section]) as $input) {
        $r->bindValue(':name', $input, PDO::PARAM_STR);
        $r->bindValue(':type', $type->value, PDO::PARAM_STR);
        $r->execute();

        try {
            if ($r->rowCount() > 0) {
                $d = $r->fetch();
                $data = Content::get($d['id'], $type);
            } else {
                $data = Content::insert(0, $type, $input);
                if (!isset($data)) {
                    echo 'A non blocking error has occurred: ' . $input;
                    break;
                }
            }
        } catch (Exception $e) {
            echo 'An error has occurred!';
            break;
        }

        $relation = new Relation();
        $relation->insert($relationType, $data->getId(), $content->getId());
    }

    $r->closeCursor();
}