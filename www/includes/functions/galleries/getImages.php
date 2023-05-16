<?php

require_once dirname(__DIR__, 3) . '/load.php';
global $DDB;

Researcher::Instance()->setType(EDataType::IMAGE);
Researcher::Instance()->setOrderBy($_GET['orderBy'] ?? 'dateCreated_DESC');
Researcher::Instance()->setOrderDirection(isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC');

$pagination = new BlockPagination('imagesPagination', RString::EMPTY, 'number of images: ', Researcher::Instance()->getCurrentPage(), Researcher::Instance()->getTotalPages(), 'getImages');
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);
$pagination->addLimitButton(200);
$pagination->addLimitButton(400);
echo $pagination->display();

$grid = new BlockGrid('imagesGrid');
$grid->setColumnCount(4);

$gallery = new Gallery($_GET['gallery']);

$relationsQuerry = '(SELECT ' . PREFIX . 'relations.child FROM ' . PREFIX . 'relations WHERE ' . PREFIX . 'relations.type = ' . Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY) . ' AND ' . PREFIX . 'relations.parent = :galleryId)';

$s = 'SELECT ' . PREFIX . 'contents.id FROM ' . PREFIX . 'contents WHERE ' . PREFIX . 'contents.id NOT IN ' . $relationsQuerry;
$s .= ' AND ' . PREFIX . 'contents.type = ' . whitelist(Researcher::Instance()->getType()->value, EDataType::values()) . ' AND ' . PREFIX . 'contents.status = ' . whitelist(Researcher::Instance()->getStatus()->value, EDataStatus::values());

if (!nullOrEmpty(Researcher::Instance()->getSearchFor())) {
    $s .= ' AND name LIKE :searchFor';
}

if (isset($orderBy)) {
    $orderParameters = explode("_", $orderBy);
    $orderBy = whitelist($orderParameters[0], AContent::COLUMNS);
    $orderDirection = whitelist($orderParameters[1], ['ASC', 'DESC']);
    $s .= ' ORDER BY ' . $orderBy . ' ' . $orderDirection;
} else {
    $s .= ' ORDER BY dateCreated DESC';
}

$s .= Researcher::Instance()->getCurrentPage() !== null ? ' LIMIT :limitMin, :limitMax' : ' LIMIT :limit';

$r = $DDB->prepare($s);

$r->bindValue(':galleryId', $gallery->getId(), PDO::PARAM_INT);

if (!nullOrEmpty(Researcher::Instance()->getSearchFor())) {
    $r->bindValue(':searchFor', '%' . Researcher::Instance()->getSearchFor() . '%', PDO::PARAM_STR);
}

if (Researcher::Instance()->getCurrentPage() !== null) {
    $r->bindValue(':limitMin', Researcher::Instance()->getCurrentPage() * Researcher::Instance()->getLimit() - Researcher::Instance()->getLimit(), PDO::PARAM_INT);
    $r->bindValue(':limitMax', Researcher::Instance()->getLimit(), PDO::PARAM_INT);
} else {
    $r->bindValue(':limit', Researcher::Instance()->getLimit(), PDO::PARAM_INT);
}

try {
    $r->execute();
    $images = array();
    while ($d = $r->fetch()) {
        $newImage = AContent::createInstance(EDataType::IMAGE, $d['id']);
        $images[] = $newImage;
    }
    $r->closeCursor();
} catch (PDOException $e) {
    Logger::logError($e->getMessage());
}

foreach ($images as $image) {
    $grid->addContent('<img id="image' . $image->getId() . '" src="' . UPLOADS_URL . FileHandler::getPath($image) . '" draggable="true" ondragstart="bindImage(event, ' . $image->getId() . ')" style="max-width:360px">');
}

?>

<div ondrop="removeFromGallery(event, <?= $gallery->getId() ?>)" ondragover="allowDrop(event)">
    <?= $grid->display() ?>
</div>