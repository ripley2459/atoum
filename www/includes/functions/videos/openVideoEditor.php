<?php

require_once dirname(__DIR__, 3) . '/load.php';

if (!isset($_GET['contentId'])) {
    die();
}

$content = new Video($_GET['contentId']);

echo '<label for="name">Name </label><input type="text" name="name" value="' . $content->getName() . '" required />';
echo '</br>';
echo '<label for="slug">Slug </label><input type="text" name="slug" value="' . $content->getSlug() . '" required disabled />';
echo '</br>';
echo '<label for="dateCreated">Date created </label><input type="datetime-local" id="dateCreated" name="dateCreated" value="' . $content->getDateCreated()->format('Y-m-d\TH:i') . '" disabled />';
echo '</br>';
echo '<label for="dateModified">Date modified </label><input type="datetime-local" id="dateModified" name="dateModified" value="' . $content->getDateModified()->format('Y-m-d\TH:i') . '" disabled />';