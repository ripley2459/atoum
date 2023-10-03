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
    ->offset(Builder::searchArgs()['view'])
    ->limit(Builder::searchArgs()['limit']);

$data = $r->execute();

while ($d = $data->fetch(PDO::FETCH_ASSOC)) {
    $img = new Image($d['id']); ?>
    <button class="image-button" onclick="linkImage(this,<?= $img->getId() ?>,[<?= $content->getId() ?>,<?= EDataType::IMAGE->value ?>,<?= EDataType::GALLERY->value ?>])">
        <img src="<?= UPLOADS_URL . FileHandler::getPath($img) ?>"/>
    </button>
<?php } ?>