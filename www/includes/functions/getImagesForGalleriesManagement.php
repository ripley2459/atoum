<?php

require_once dirname(__DIR__, 2) . '/load.php';

$type = EContentType::IMAGE->value;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$currentPage = $_GET['currentPage'] ?? 1;
$totalPages = ceil(AContent::getAmount($type) / $limit);

$minusPage = $currentPage == 1 ? '<button onclick="setCurrentPage(' . $currentPage - 1 . ')" disabled><</button>' : '<button onclick="setCurrentPage(' . $currentPage - 1 . ')"><</button>';
$maxPage = $currentPage == $totalPages ? '<button onclick="setCurrentPage(' . $currentPage + 1 . ')" disabled>></button>' : '<button onclick="setCurrentPage(' . $currentPage + 1 . ')">></button>';

$pagination = '<div>Number of lines: <button onclick="setLimit(25)">25</button><button onclick="setLimit(50)">50</button><button onclick="setLimit(75)">75</button><button onclick="setLimit(100)">100</button><button onclick="setLimit(200)">200</button>' . $minusPage . $currentPage . '/' . $totalPages . $maxPage . '</div>';

?>

<?= $pagination ?>
    <div id="registeredGalleries">
        <?php foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage) as $content): ?>
            <div id="<?= $content->getId() ?>" class="galleryFolder">
                <h3><?= $content->getName() ?></h3>
            </div>
        <?php endforeach ?>
    </div>
<?= $pagination ?>