<?php

require_once dirname(__DIR__, 3) . '/load.php';

$type = EDataType::ACTOR->value;
$status = $_GET['status'] ?? null;
$orderBy = $_GET['orderBy'] ?? null;
$orderDirection = isset($orderBy) ? switchOrderDirection($orderBy) : 'ASC';
$limit = $_GET['limit'] ?? 100;
$currentPage = $_GET['currentPage'] ?? 1;
$searchFor = RString::EMPTY;

$pagination = new BlockPagination('actorsPagination', RString::EMPTY, 'number of lines: ', $currentPage, ceil(AContent::getAmount($type) / $limit));
$pagination->addLimitButton(25);
$pagination->addLimitButton(50);
$pagination->addLimitButton(100);

$pagination->display();

?>

<table>
    <tr>
        <th>
            <button onclick="setURLParam('orderBy', '<?= 'name_' . $orderDirection ?>', listFiles)">Name</button>
        </th>
        <th>
            <button onclick="setURLParam('orderBy', '<?= 'status_' . $orderDirection ?>', listFiles)">Status</button>
        </th>
        <th>
            <button onclick="setURLParam('orderBy', '<?= 'dateCreated_' . $orderDirection ?>', listFiles)">Created</button>
        </th>
        <th>
            <button onclick="setURLParam('orderBy', '<?= 'views_' . $orderDirection ?>', listFiles)">Views</button>
        </th>
    </tr>
    <?php foreach (AContent::getAll($type, $status, $orderBy, $limit, $currentPage, $searchFor) as $content): ?>
        <tr>
            <td><?= $content->getName() ?>
                <div>
                    <input type="checkbox" id="<?= $content->getId() ?>" value="Bike"><button onclick="openContentModal(<?= $content->getId() ?>)">Edit</button><button onclick="deleteContent(<?= $content->getId() ?>)">Delete</button>
                </div>
            </td>
            <td>
                <button onclick="toggleURLParam('status', <?= $content->getStatus()->value ?>, listFiles)"><?= ucfirst(strtolower($content->getStatus()->name)) ?></button>
            </td>
            <td><?= $content->getDateCreated()->format('Y/m/d H:i') ?></td>
            <td><?= $content->getViews() ?></td>
        </tr>
    <?php endforeach ?>
</table>