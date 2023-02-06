<?php

require_once dirname(__DIR__, 4) . '/load.php';

if (!isset($_GET['id'])) return;
$id = 'contentModal-' . $_GET['id'];
$modalContent = '<button onclick="toggleModal(' . $id . ')">Close</button>';

// TODO FORMULAIRE POUR EDIT L'INSTANCE

$modalContent .= '<button onclick="saveEditContent(' . $id . ')">Save and Close</button>';
$modal = new BlockModal($id, $modalContent);

$modal->echo();