<?php

require_once dirname(__DIR__, 3) . '/load.php';
global $DDB;

$type = EDataType::IMAGE->value;
$status = EDataStatus::PUBLISHED->value;
$orderBy = $_GET['orderBy'] ?? 'name_ASC';
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$searchFor = $_GET['searchFor'] ?? RString::EMPTY;
$currentPage = $_GET['currentPage'] ?? 1;
$totalPages = ceil(AContent::getAmount($type) / $limit);

$pagination = new BlockPagination('imagesPagination', RString::EMPTY, 'number of images: ', $currentPage, $totalPages, 'getImages');
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);
$pagination->addLimitButton(200);
$pagination->addLimitButton(400);
$pagination->display();

$grid = new BlockGrid('imagesGrid');
$grid->setColumnCount(4);

$gallery = new Gallery($_GET['gallery']);

$relationsQuerry = '(SELECT ' . PREFIX . 'relations.child FROM ' . PREFIX . 'relations WHERE ' . PREFIX . 'relations.type = ' . Relation::getRelationType(EDataType::IMAGE, EDataType::GALLERY) . ' AND ' . PREFIX . 'relations.parent = :galleryId)';

$s = 'SELECT ' . PREFIX . 'contents.id FROM ' . PREFIX . 'contents WHERE ' . PREFIX . 'contents.id NOT IN ' . $relationsQuerry;
$s .= ' AND ' . PREFIX . 'contents.type = ' . whitelist($type, EDataType::values()) . ' AND ' . PREFIX . 'contents.status = ' . whitelist($status, EDataStatus::values());

if (!nullOrEmpty($searchFor)) {
    $s .= ' AND name LIKE :searchFor';
}

if (isset($orderBy)) {
    $orderParameters = explode("_", $orderBy);
    $orderBy = whitelist($orderParameters[0], AContent::COLUMNS);
    $orderDirection = whitelist($orderParameters[1], ['ASC', 'DESC']);
    $s .= ' ORDER BY ' . $orderBy . ' ' . $orderDirection;
}

$s .= isset($currentPage) ? ' LIMIT :limitMin, :limitMax' : ' LIMIT :limit';

$r = $DDB->prepare($s);

$r->bindValue(':galleryId', $gallery->getId(), PDO::PARAM_INT);

if (!nullOrEmpty($searchFor)) {
    $r->bindValue(':searchFor', '%' . $searchFor . '%', PDO::PARAM_STR);
}

if (isset($currentPage)) {
    $r->bindValue(':limitMin', $currentPage * $limit - $limit, PDO::PARAM_INT);
    $r->bindValue(':limitMax', $limit, PDO::PARAM_INT);
} else {
    $r->bindValue(':limit', $limit, PDO::PARAM_INT);
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
    $grid->addElement('<img id="image' . $image->getId() . '" src="' . UPLOADS_URL . FileHandler::getPath($image) . '" draggable="true" ondragstart="bindImage(event, ' . $image->getId() . ')" style="max-width:360px">');
}

?>

<div ondrop="removeFromGallery(event, <?= $gallery->getId() ?>)" ondragover="allowDrop(event)">
    <?= $grid->display() ?>
</div>