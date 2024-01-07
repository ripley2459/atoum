<?php

$content = new Content(R::getParameter('data'));

$notLinked = RDB::select('relations', 'relations.child')
    ->where('relations.parent', '=', $content->getId())
    ->where('relations.type', '=', Relation::getTypeFor(EDataType::IMAGE, $content->getType()));

$request = RDB::select('contents', 'contents.id')
    ->where('contents.id')->notIn($notLinked)
    ->where('contents.type', '=', EDataType::IMAGE->value)
    ->limit(App::args()['offset'] * App::args()['limit'] - App::args()['limit'], App::args()['limit'])
    ->orderBy(App::args()['orderBy'][0], App::args()['orderBy'][1]);
if (!R::blank(App::args()['search']))
    $request->where('name')->contains(App::args()['search']);

$data = $request->execute();

$images = [];
while ($d = $data->fetch(PDO::FETCH_ASSOC))
    $images[] = new Content($d['id']);

$checkActors = !R::blank(App::args()['actors']);
$checkTags = !R::blank(App::args()['tags']);

if ($checkActors) {
    $a = RDB::select('contents', 'id')
        ->where('name')->in(App::args()['actors'])
        ->where('type', '=', EDataType::ACTOR->value)
        ->execute();

    $ac = [];
    while ($d = $a->fetch(PDO::FETCH_ASSOC))
        $ac[] = new Content($d['id']);

    $actors = [];
    foreach ($ac as $actor)
        $actors[] = Relation::getRelated($actor, EDataType::IMAGE, false);
    $actors = R::flattenArray($actors);
}

if ($checkTags) {
    $t = RDB::select('contents', 'id')
        ->where('name')->in(App::args()['tags'])
        ->where('type', '=', EDataType::ACTOR->value)
        ->execute();

    $ta = [];
    while ($d = $t->fetch(PDO::FETCH_ASSOC))
        $ta[] = new Content($d['id']);

    $tags = [];
    foreach ($ta as $tag)
        $tags[] = Relation::getRelated($tag, EDataType::IMAGE, false);
    $tags = R::flattenArray($tags);
}

if ($checkActors)
    $images = array_uintersect($images, $actors, function ($a, $b) {
        return strcmp($a->getSlug(), $b->getSlug());
    });
if ($checkTags)
    $images = array_uintersect($images, $tags, function ($a, $b) {
        return strcmp($a->getSlug(), $b->getSlug());
    });

foreach ($images as $image) { ?>
    <button class="image-button" onclick="linkImage(this,<?= $image->getId() ?>)">
        <?php image($image) ?>
    </button>
<?php } ?>
