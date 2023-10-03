<?php

require_once dirname(__DIR__, 2) . '/load.php';
global $DDB;

$r = Request::select(PREFIX . 'contents', 'id', 'type')
    ->where('type', '=', Builder::searchArgs()['type'])
    ->where('status', '=', Builder::searchArgs()['status'])
    ->where('name', 'LIKE', Builder::searchArgs()['search'])
    ->orderBy(Builder::searchArgs()['order'])
    ->offset(Builder::searchArgs()['view'])
    ->limit(Builder::searchArgs()['limit']);

$data = $r->execute();
$contents = array();

while ($d = $data->fetch(PDO::FETCH_ASSOC)) {
    $contents[] = Content::get($d['id'], EDataType::from($d['type']));
}

if (Builder::searchArgs()['display'] == 1) {
    foreach ($contents as $content) {
        echo '
            <tr>
                <td>' . $content->getName() . '</td>
                <td>' . Blocks::buttonUrlParamSet($content->getType()->name, 'type', $content->getType()->value, 'noparse:getUploads') . '</td>
                <td>' . $content->getDateCreated()->format('Y/m/d H:i') . '</td>
                <td>' . $content->getViews() . '</td>
                <td>' . $content->getContent() . '</td>
                <td><button onclick="' . R::createFunctionJS('openEdit', $content->getId(), $content->getType()->value) . '">Edit</button>' . Blocks::viewLink($content) . '</td>
            </tr>';
    }
} else if (Builder::searchArgs()['display'] == 0) {
    $e = '<div class="grid" style="column-count: 5">';
    foreach ($contents as $content) {
        $e .= $content->display();
    }
    echo $e . '</div>';
} else {
    echo 'No valid display configuration provided!';
}