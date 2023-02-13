<?php

require_once dirname(__DIR__, 2) . '/load.php';

if (!isset($_GET['id'])) return;
$id = 'contentModal-' . $_GET['id'];
$modalContent = '<button onclick="toggleModal(' . $id . ')">Close</button>';
$content = AContent::getInstance($_GET['id']);
// TODO FORMULAIRE POUR EDIT L'INSTANCE

$modalContent .= '<form id="form">';
$modalContent .= '<label for="dateCreated">Date created</label><input type="datetime-local" id="dateCreated" name="dateCreated" value="' . $content->getDateCreated()->format('Y-m-d\TH:i') . '" disabled />';
$modalContent .= '<label for="dateModified">Date modified</label><input type="datetime-local" id="dateModified" name="dateModified" value="' . $content->getDateModified()->format('Y-m-d\TH:i') . '" disabled />';

$modalContent .= '<label for="name">Name</label><input type="text" name="name" value="' . $content->getName() . '" required />';
$modalContent .= '<label for="slug">Slug</label><input type="text" name="slug" value="' . $content->getSlug() . '" required disabled />';

$modalContent .= '</form>';

$modalContent .= '<button onclick="saveEditContent(' . $id . ')">Save and Close</button>';
$modal = new BlockModal($id, $modalContent);

$modal->echo();