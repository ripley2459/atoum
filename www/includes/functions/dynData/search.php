<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (isset($_GET['type']) && isset($_GET['search']) && isset($_GET['field'])) {
    $type = EDataType::fromInt($_GET['type']);
    $search = $_GET['search'];
    $field = $_GET['field'];

    foreach (AContent::getAll($type->value, EDataStatus::PUBLISHED->value, null, PHP_INT_MAX, null, $search) as $content) {
        ?>
        <button onclick="DynDataAdd('<?= $content->getName() ?>', <?= $type->value ?>, '<?= $field ?>')"><?= $content->getName() ?></button>
        <?php
    }
}