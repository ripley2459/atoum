<?php

require_once dirname(__DIR__, 2) . '/load.php';
R::require('id');
global $DDB;

$content = new Content($_GET['id']);

$sr = Request::select(PREFIX . 'relations', 'child')
    ->where('type', '=', Relation::getRelationType(EDataType::IMAGE, $content->getType()))
    ->where('parent', '=', $content->getId());

$r = Request::select(PREFIX . 'contents', 'id', 'type')
    ->where('type', '=', EDataType::IMAGE->value)
    ->where('status', '=', Builder::searchArgs()['status'])
    ->where('name', 'LIKE', Builder::searchArgs()['search'])
    ->sub(PREFIX . 'contents.id NOT IN', $sr)
    ->orderBy(Builder::searchArgs()['order'])
    ->offset(Builder::searchArgs()['page'])
    ->limit(Builder::searchArgs()['limit']);

$data = $r->execute();

?>

<div class="grid fake-container" style="column-count: 5" ondrop="unlinkImage(event, [<?= $content->getId() ?>, <?= EDataType::IMAGE->value ?>,<?= EDataType::GALLERY->value ?>])" ondragover="allowDrop(event)">
    <?php while ($d = $data->fetch(PDO::FETCH_ASSOC)) {
        $img = new Image($d['id']); ?>
        <img id="<?= $img->getSlug() ?>" src="<?= UPLOADS_URL . FileHandler::getPath($img) ?>" draggable="true" ondragstart="bindImage(event, <?= $img->getId() ?>)"/>
    <?php } ?>
</div>