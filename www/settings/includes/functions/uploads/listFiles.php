<?php

require_once dirname(__DIR__, 4) . '/load.php';

$type = $_GET['type'] ?? null;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$currentPage = $_GET['currentPage'] ?? 1;
$totalPages = ceil(Content::getAmount($type) / $limit);

$minusPage = $currentPage == 1 ? '<button onclick="setCurrentPage(' . $currentPage - 1 . ')" disabled><</button>' : '<button onclick="setCurrentPage(' . $currentPage - 1 . ')"><</button>';
$maxPage = $currentPage == $totalPages ? '<button onclick="setCurrentPage(' . $currentPage + 1 . ')" disabled>></button>' : '<button onclick="setCurrentPage(' . $currentPage + 1 . ')">></button>';

$pagination = 'Number of lines: <button onclick="setLimit(25)">25</button><button onclick="setLimit(50)">50</button><button onclick="setLimit(75)">75</button><button onclick="setLimit(100)">100</button><button onclick="setLimit(200)">200</button>' . $minusPage . $currentPage . '/' . $totalPages . $maxPage;

?>

<?= $pagination ?>
    <table>
        <tr>
            <th>
                <button onclick="setOrderBy('<?= 'name_' . $orderDirection ?>')">Name</button>
            </th>
            <th>
                <button onclick="setOrderBy('<?= 'type_' . $orderDirection ?>')">Type</button>
            </th>
            <th>
                <button onclick="setOrderBy('<?= 'status_' . $orderDirection ?>')">Status</button>
            </th>
            <th>
                <button onclick="setOrderBy('<?= 'dateCreated_' . $orderDirection ?>')">Created</button>
            </th>
            <th>
                <button onclick="setOrderBy('<?= 'views_' . $orderDirection ?>')">Views</button>
            </th>
        </tr>
        <?php foreach (Content::getAll($type, $status, $orderBy, $limit, $currentPage) as $content): ?>
            <tr>
                <td><?= $content->getName() ?></td>
                <td>
                    <button onclick="setType(<?= $content->getType()->value ?>)"><?= ucfirst(strtolower($content->getType()->name)) ?></button>
                </td>
                <td>
                    <button onclick="setStatus(<?= $content->getStatus()->value ?>)"><?= ucfirst(strtolower($content->getStatus()->name)) ?></button>
                </td>
                <td><?= $content->getDateCreated()->format('Y/m/d H:i') ?></td>
                <td><?= $content->getViews() ?></td>
            </tr>
        <?php endforeach ?>
    </table>

<?= $pagination ?>