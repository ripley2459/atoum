<?php

require_once dirname(__DIR__, 3) . '/load.php';

$pagination = new BlockPagination('contentPagination', RString::EMPTY, 'number of lines: ', Researcher::Instance()->getCurrentPage(), Researcher::Instance()->getTotalPages(), 'listFiles');
$pagination->addLimitButton(5);
$pagination->addLimitButton(10);
$pagination->addLimitButton(20);
$pagination->addLimitButton(50);

?>

<?= $pagination->display() ?>
<table>
    <tr>
        <th>
            <button onclick="setURLParam('orderBy', '<?= 'name_' . Researcher::Instance()->getOrderDirection() ?>', listFiles)">Name</button>
        </th>
        <th>
            <button onclick="setURLParam('orderBy', '<?= 'type_' . Researcher::Instance()->getOrderDirection() ?>', listFiles)">Type</button>
        </th>
        <th>
            <button onclick="setURLParam('orderBy', '<?= 'status_' . Researcher::Instance()->getOrderDirection() ?>', listFiles)">Status</button>
        </th>
        <th>
            <button onclick="setURLParam('orderBy', '<?= 'dateCreated_' . Researcher::Instance()->getOrderDirection() ?>', listFiles)">Created</button>
        </th>
        <th>
            <button onclick="setURLParam('orderBy', '<?= 'views_' . Researcher::Instance()->getOrderDirection() ?>', listFiles)">Views</button>
        </th>
        <?php if (Researcher::Instance()->getDisplayContent()) echo '<th>Content</th>' ?>
    </tr>
    <?php foreach (AContent::getAll(Researcher::Instance()->getType(), Researcher::Instance()->getStatus(), Researcher::Instance()->getOrderBy(), Researcher::Instance()->getLimit(), Researcher::Instance()->getCurrentPage(), Researcher::Instance()->getSearchFor()) as $content): ?>
        <tr>
            <td><?= $content->getName() ?>
                <div>
                    <input type="checkbox" id="<?= $content->getId() ?>" value="Bike"><button onclick="openContentModal(<?= $content->getId() ?>)">Edit</button><button onclick="deleteContent(<?= $content->getId() ?>, <?= $content->getType()->value ?>)">Delete</button>
                </div>
            </td>
            <td>
                <button onclick="toggleURLParam('type', <?= $content->getType()->value ?>, listFiles)"><?= ucfirst(strtolower($content->getType()->name)) ?></button>
            </td>
            <td>
                <button onclick="toggleURLParam('status', <?= $content->getStatus()->value ?>, listFiles)"><?= ucfirst(strtolower($content->getStatus()->name)) ?></button>
            </td>
            <td><?= $content->getDateCreated()->format('Y/m/d H:i') ?></td>
            <td><?= $content->getViews() ?></td>
            <?php if (Researcher::Instance()->getDisplayContent()) echo '<td>' . $content->display() . '</td>' ?>
        </tr>
    <?php endforeach ?>
</table>