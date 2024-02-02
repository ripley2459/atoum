<?php

$request = RDB::select('contents', 'id', 'type', 'name')
    ->limit(App::args()['offset'] * App::args()['limit'] - App::args()['limit'], App::args()['limit'])
    ->orderBy(App::args()['orderBy'][0], App::args()['orderBy'][1]);
if (!R::blank(App::args()['search']))
    $request->where('name')->contains(App::args()['search']);
if (App::args()['type'] >= 0)
    $request->where('type', '=', App::args()['type']);

$data = $request->execute();
$display = R::getParameter('displayMode', 'table');

$values = array();
while ($d = $data->fetch(PDO::FETCH_ASSOC)) {
    $values[] = new Content($d['id']);
}

if ($display == 'grid') {
    ?>
    <tr>
        <td colspan="4">
            <div class="masonry" style="column-count: 5">
                <?php foreach ($values as $value) {
                    if ($value->getType() == EDataType::IMAGE)
                        image($value);
                    else if ($value->getType() == EDataType::VIDEO)
                        videoLinkWithPoster($value);
                    else { ?>
                        <div><?= $value->getName() ?></div>
                    <?php }
                } ?>
            </div>
        </td>
    </tr>
    <?php
} else if ($display == 'table') {
    foreach ($values as $value) { ?>
        <tr>
            <td><?= $value->getName() ?></td>
            <td>
                <button class="light" onclick="toggleParam('type', <?= $value->getType()->value ?>)"><?php eDataTypeToString($value->getType()) ?></button>
            </td>
            <td><?= $value->getDateCreated()->format('j F Y') ?></td>
            <td>
                <a class="button light" href="<?= App::getLink('edit', 'data=' . $value->getId()) ?>" target="_blank">Edit</a>
                <?php if ($value->getType() == EDataType::GALLERY) { ?>
                    <a class="button light" href="<?= App::getLink('gallery', 'gallery=' . $value->getId()) ?>">View</a>
                    <?php
                } else if ($value->getType() == EDataType::VIDEO) { ?>
                    <a class="button light" href="<?= App::getLink('video', 'video=' . $value->getId()) ?>">View</a>
                <?php } else if ($value->getType() == EDataType::PLAYLIST) { ?>
                    <a class="button light" href="<?= App::getLink('playlist', 'playlist=' . $value->getId()) ?>">View</a>
                <?php } ?>
            </td>
        </tr>
    <?php }
}