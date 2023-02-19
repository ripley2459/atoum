<?php

require_once dirname(__DIR__, 2) . '/load.php';

if (!isset($_GET['contentId'])) return;

$content = AContent::getInstance($_GET['contentId']);
$modalId = 'contentModal' . $_GET['contentId'];
$modalContent = '<button onclick="toggleModal(\'' . $modalId . '\')">Close</button>';
// TODO FORMULAIRE POUR EDIT L'INSTANCE

$modalContent .= '<form id="form">';

$modalContent .= '<label for="dateCreated">Date created</label><input type="datetime-local" id="dateCreated" name="dateCreated" value="' . $content->getDateCreated()->format('Y-m-d\TH:i') . '" disabled />';
$modalContent .= '<label for="dateModified">Date modified</label><input type="datetime-local" id="dateModified" name="dateModified" value="' . $content->getDateModified()->format('Y-m-d\TH:i') . '" disabled />';

$modalContent .= '<label for="name">Name</label><input type="text" name="name" value="' . $content->getName() . '" required />';
$modalContent .= '<label for="slug">Slug</label><input type="text" name="slug" value="' . $content->getSlug() . '" required disabled />';

$modalContent .= '</form>';

$modalContent .= '<button onclick="saveEditContent(' . $_GET['contentId'] . ')">Save and Close</button>';

$modal = new BlockModal($modalId, RString::EMPTY, $modalContent);
$modal->display();