<h1>Atoum's administration</h1>

<div>
    <h2>Scripts</h2>
    <?php

    $scriptsPath = CONTENT . 'scripts';
    FileHandler::checkPath($scriptsPath);
    foreach (normalizedScan($scriptsPath) as $script) {
        echo '<button onclick="getFrom(\'' . URL . '/content/scripts/' . $script . '\', \'scriptsResult\')">' . $script . '</button>';
    }

    ?>
    <div id="scriptsResult"></div>
</div>

<?php

Researcher::Instance()->setType(EDataType::VIDEO);
Researcher::Instance()->setStatus(EDataStatus::PUBLISHED);
Researcher::Instance()->setOrderBy("dateCreated_DESC");
Researcher::Instance()->setLimit(99999);

$noTags = array();
$noActors = array();
$noThumbnails = array();

foreach (AContent::getAll(Researcher::Instance()->getType(), Researcher::Instance()->getStatus(), Researcher::Instance()->getOrderBy(), Researcher::Instance()->getLimit(), Researcher::Instance()->getCurrentPage(), Researcher::Instance()->getSearchFor()) as $video) {
    if (count(Relation::getChildren(Relation::getRelationType(EDataType::TAG, Researcher::Instance()->getType()), $video->getId())) < 2) {
        $noTags[] = $video;
    }

    if (count(Relation::getChildren(Relation::getRelationType(EDataType::ACTOR, Researcher::Instance()->getType()), $video->getId())) < 1) {
        $noActors[] = $video;
    }

    if (!file_exists(UPLOADS . FileHandler::getPath($video) . '.png')) {
        $noThumbnails[] = $video;
    }
}

if (count($noTags) > 0) {
    echo '<h2>These videos do not have at least 2 linked tags:</h2>';
    echo '<ul>';
    foreach ($noTags as $no) {
        echo '<li><a href="' . URL . '/index.php?page=viewVideo&video=' . $no->getId() . '">' . $no->getName() . '</a></li>';
    }
    echo '</ul>';
}

if (count($noActors) > 0) {
    echo '<h2>These videos do not have at least 1 linked actor:</h2>';
    echo '<ul>';
    foreach ($noActors as $no) {
        echo '<li><a href="' . URL . '/index.php?page=viewVideo&video=' . $no->getId() . '">' . $no->getName() . '</a></li>';
    }
    echo '</ul>';
}

if (count($noThumbnails) > 0) {
    echo '<h2>These videos do not have a thumbnail:</h2>';
    echo '<ul>';
    foreach ($noThumbnails as $no) {
        echo '<li><a href="' . URL . '/index.php?page=viewVideo&video=' . $no->getId() . '">' . $no->getName() . '</a></li>';
    }
    echo '</ul>';

}