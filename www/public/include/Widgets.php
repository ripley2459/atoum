<?php

function typeahead(string $name, string $label, string $placeholder, EDataType $type, AContent $reference = null): void
{ ?>
    <div>
        <label for="<?= $name ?>"><?= $label ?></label>
        <div class="typeahead">
            <div id="<?= $name ?>-input">
                <?php if (isset($reference)) {
                    foreach (Relation::getRelated($reference, $type) as $in) { ?>
                        <div id="<?= strtolower($in->getSlug()) ?>-input-container" class="input">
                            <input type="text" class="<?= $name ?>-value" value="<?= $in->getName() ?>" readonly="" name="<?= $name ?>[]">
                            <button type="button" onclick="typeaheadRemove('<?= $name ?>[]', '<?= strtolower($in->getSlug()) ?>-input-container')">x</button>
                        </div>
                    <?php }
                } ?>
                <input class="u-full-width" type="text" placeholder="<?= $placeholder ?>" id="<?= $name ?>" onkeyup="typeaheadSearch('<?= $name ?>', <?= $type->value ?>)"
                       onkeydown="typeaheadOnKey('<?= $name ?>')">
            </div>
            <div id="<?= $name ?>-result" class="search-result"></div>
        </div>
    </div>
<?php }

function buttonSearchData(string $id, string $value): void
{ ?>
    <button type="button" onclick="typeaheadAdd('<?= $id ?>', '<?= $value ?>')"><?= $value ?></button>
<?php }

function image(Content $image): void
{ ?>
    <img id="<?= $image->getSlug() ?>" src="<?= FileHandler::getURL($image) ?>" alt="<?= $image->getName() ?>"/>
<?php }

function eDataTypeToString(EDataType $type): void
{ ?>
    <?= ucwords(strtolower($type->name)) ?>
<?php }

function pagination(bool $displayMode): void
{ ?>
    <div class="row u-padd-top u-padd-bot">
        <?php if ($displayMode) { ?>
            <div class="four columns">
                <button class="light" onclick="setParam('displayMode', 'table')" name="displayMode" id="displayMode-table">Table</button>
                <button class="light" onclick="setParam('displayMode', 'grid')" name="displayMode" id="displayMode-grid">Grid</button>
            </div>
        <?php } ?>
        <div id="pagination" class="<?= $displayMode ? 'four' : 'six' ?> columns">
            <button class="light" onclick="setParam('offset', 10)" name="offset" id="offset-10">◄</button>
            <button class="light" onclick="setParam('offset', 25)" name="offset" id="offset-25">5/10</button>
            <button class="light" onclick="setParam('offset', 50)" name="offset" id="offset-50">►</button>
        </div>
        <div class="<?= $displayMode ? 'four' : 'six' ?> columns">
            <button class="light" onclick="setParam('limit', 20)" name="limit" id="limit-20">20</button>
            <button class="light" onclick="setParam('limit', 50)" name="limit" id="limit-50">50</button>
            <button class="light" onclick="setParam('limit', 100)" name="limit" id="limit-100">100</button>
            <button class="light" onclick="setParam('limit', 200)" name="limit" id="limit-200">200</button>
            <button class="light" onclick="setParam('limit', 500)" name="limit" id="limit-500">500</button>
        </div>
    </div>
<?php }

function notifications(): void
{ ?>
    <div id="notifications">

    </div>
<?php }

function notification(string $content): void
{ ?>
    <div class="notification">
        <?= $content ?>
    </div>
<?php }

/* ==================================================
 * Loader
 */

function loadingPage(): void
{ ?>
    <div id="loadingPage">
        <span class="loader"></span>
    </div>
<?php }

function last(int $amount = 100): void
{
    $data = RDB::select('contents', 'id')
        //->where('type', '=', EDataType::IMAGE->value)
        //->or()
        ->where('type', '=', EDataType::VIDEO->value)
        ->or()
        ->where('type', '=', EDataType::GALLERY->value)
        ->limit($amount)
        ->orderBy('id', 'DESC')
        ->execute();

    $values = array();
    while ($d = $data->fetch(PDO::FETCH_ASSOC))
        $values[] = new Content($d['id']);
    $data->closeCursor();
    ?>
    <div class="masonry">
        <?php foreach ($values as $value) {
            switch ($value->getType()) {
                case EDataType::IMAGE:
                    image($value);
                    break;
                case EDataType::VIDEO:
                    videoLinkWithPoster($value);
                    break;
                case EDataType::GALLERY:
                    $value->getName();
                    break;
                default:
                    throw new \Exception('Unexpected value');
            }
        } ?>
    </div>
<?php }

/* ==================================================
 * Video
 */

function videoLinkWithPoster(Content $video): void
{ ?>
    <!-- class="video-preview" -->
    <a href="<?= App::getLink('video', 'video=' . $video->getId()) ?>" data-src="<?= FileHandler::getURL($video) ?>">
        <img id="<?= $video->getSlug() ?>-poster" class="video-thumbnail" src="<?= videoPoster($video) ?>" alt="<?= $video->getName() ?>"/>
    </a>
<?php }

function videoPoster(Content $content, bool $asImage = false): string
{
    $poster = FileHandler::getURL($content) . '.png';
    $poster = file_exists(FileHandler::getPath($content) . '.png') ? $poster : App::include('video-poster-placeholder.png');
    return $asImage ? '<img id="video-' . $content->getId() . '-poster" class="video-thumbnail" src="' . $poster . '" alt="' . $content->getName() . '"/>' : $poster;
}

function videoPlayer(Content $video): void
{ ?>
    <div id="<?= $video->getId() ?>-video-container" class="video-container">
        <video id="<?= $video->getId() ?>-video-player" class="video-player" src="<?= FileHandler::getURL($video) ?>" controls poster="<?= videoPoster($video) ?>"></video>
    </div>
<?php }

/* ==================================================
 * Gallery
 */

function galleryFromContent(Content $data): void
{
    $images = Relation::getRelated($data, EDataType::IMAGE, shuffle: true);
    galleryFromImages($data->getId(), $images);
}

function galleryFromImages(string $galleryId, array $images): void
{ ?>
    <div id="<?= $galleryId ?>-gallery-container" class="gallery-container">
        <div id="<?= $galleryId ?>-gallery-grid" class="gallery-grid masonry">
            <?php $i = 0;
            foreach ($images as $image) { ?>
                <img src="<?= FileHandler::getURL($image) ?>" onclick="showSlide(<?= ++$i ?>, '<?= $galleryId ?>-gallery')" alt="<?= $image->getName() ?>">
            <?php } ?>
        </div>
        <div id="<?= $galleryId ?>-gallery-modal" class="gallery-modal modal">
            <div id="<?= $galleryId ?>-gallery-controls" class="gallery-controls">1/100</div>
            <div id="<?= $galleryId ?>-gallery-slides" class="gallery-slides">
                <?php $i = 0;
                foreach ($images as $image) { ?>
                    <img src="<?= FileHandler::getURL($image) ?>" class="gallery-slide" onclick="showSlide(<?= ++$i ?>, '<?= $galleryId ?>-gallery')" alt="<?= $image->getName() ?>">
                <?php } ?>
            </div>
            <div id="<?= $galleryId ?>-gallery-thumbnails" class="gallery-thumbnails">
                <?php $i = 0;
                foreach ($images as $image) { ?>
                    <img src="<?= FileHandler::getURL($image) ?>" onclick="showSlide(<?= ++$i ?>, '<?= $galleryId ?>-gallery')" alt="<?= $image->getName() ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php }

/* ==================================================
 * Data
 */

function dataInfo(Content $data): void
{ ?>
    <div id="<?= $data->getId() ?>-data-container" class="data-container">
        <div class="row">
            <h1><?= $data->getName() ?></h1>
        </div>
        <div class="row">
            <h3>With</h3>
            <div class="actors list">
                <?php
                $actors = array();
                foreach (Relation::getRelated($data, EDataType::ACTOR) as $actor) {
                    $actors[] = $actor ?>
                    <a href="#" class="button light"><?= $actor->getName() ?></a>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <h3>Tags</h3>
            <div class="tags list">
                <?php
                $tags = array();
                foreach ($actors as $actor)
                    foreach (Relation::getRelated($actor, EDataType::TAG) as $sub)
                        $tags[] = $sub;
                foreach (Relation::getRelated($data, EDataType::TAG) as $sub)
                    $tags[] = $sub;
                $tags = array_unique($tags);
                foreach ($tags as $sub) { ?>
                    <a href="#" class="button light"><?= $sub->getName() ?></a>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <h3>Settings</h3>
            <div class="settings list">
                <a class="button light" href="<?= App::getLink('edit', 'data=' . $data->getId()) ?>" target="_blank">Edit</a>
            </div>
        </div>
    </div>
<?php }

/* ==================================================
 * Data
 */

function playlist(Content $data): void
{
    $active = R::getParameter('video', -1);
    $videos = Relation::getRelated($data, EDataType::VIDEO);
    $actual = $videos[0]; ?>
    <div id="<?= $data->getId() ?>-playlist-container" class="playlist-container">
        <div id="<?= $data->getId() ?>-playlist-videos" class="playlist-videos row">
            <?php foreach ($videos as $video) {
                if ($video->getId() == $active)
                    $actual = $video; ?>
                <a href="<?= App::getLink('playlist', 'playlist=' . $data->getId(), 'video=' . $video->getId()) ?>">
                    <img src="<?= videoPoster($video) ?>"
                         onclick="setParam('video',<?= $video->getId() ?>)"
                         alt="<?= $video->getName() ?>">
                </a>
            <?php } ?>
        </div>
        <?php videoPlayer($active == -1 ? $videos[0] : $actual); ?>
    </div>
<?php }