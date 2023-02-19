<?php

require_once dirname(__DIR__, 2) . '/load.php';

$type = $_GET['type'] ?? null;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$searchFor = $_GET['searchFor'] ?? RString::EMPTY;
$currentPage = $_GET['currentPage'] ?? 1;
$totalPages = ceil(AContent::getAmount($type) / $limit);

$pagination = new BlockPagination('contentPagination', RString::EMPTY, 'number of lines: ', $currentPage, $totalPages, 'listFiles');
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);
$pagination->addLimitButton(200);
$pagination->addLimitButton(400);

$displayContent = $_GET['displayContent'] ?? true;

?>

<?= $pagination->display() ?>
<table>
    <tr>
        <th>
            <button onclick="setOrderBy('<?= 'name_' . $orderDirection ?>', listFiles)">Name</button>
        </th>
        <th>
            <button onclick="setOrderBy('<?= 'type_' . $orderDirection ?>', listFiles)">Type</button>
        </th>
        <th>
            <button onclick="setOrderBy('<?= 'status_' . $orderDirection ?>', listFiles)">Status</button>
        </th>
        <th>
            <button onclick="setOrderBy('<?= 'dateCreated_' . $orderDirection ?>', listFiles)">Created</button>
        </th>
        <th>
            <button onclick="setOrderBy('<?= 'views_' . $orderDirection ?>', listFiles)">Views</button>
        </th>
        <?php if ($displayContent) echo '<th>Content</th>' ?>
    </tr>
    <?php foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage, $searchFor) as $content): ?>
        <tr>
            <td><?= $content->getName() ?>
                <div>
                    <input type="checkbox" id="<?= $content->getId() ?>" value="Bike"><button onclick="openContentModal(<?= $content->getId() ?>)">Edit</button><button onclick="deleteContent(<?= $content->getId() ?>)">Delete</button>
                </div>
            </td>
            <td>
                <button onclick="setType(<?= $content->getType()->value ?>, listFiles)"><?= ucfirst(strtolower($content->getType()->name)) ?></button>
            </td>
            <td>
                <button onclick="setStatus(<?= $content->getStatus()->value ?>, listFiles)"><?= ucfirst(strtolower($content->getStatus()->name)) ?></button>
            </td>
            <td><?= $content->getDateCreated()->format('Y/m/d H:i') ?></td>
            <td><?= $content->getViews() ?></td>
            <?php if ($displayContent && $content instanceof IFile) echo '<td><img src="' . UPLOADS_URL . FileHandler::getPath($content) . '" style="max-width:360px"></td>' ?>
        </tr>
    <?php endforeach ?>
</table>