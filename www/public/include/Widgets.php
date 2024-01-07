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

function videoLinkWithPoster(Content $video): void
{ ?>
    <a href="<?= App::getLink('video', 'video=' . $video->getId()) ?>"><img id="<?= $video->getSlug() ?>" src="<?= videoPoster($video) ?>" alt="<?= $video->getName() ?>"/></a>
<?php }

function videoPoster(Content $content): string
{
    $poster = FileHandler::getURL($content) . '.png';
    return file_exists(FileHandler::getPath($content) . '.png') ? $poster : App::include('video-poster-placeholder.png');
}

function videoPlayer(Content $video): void
{ ?>
    <video id="<?= $video->getSlug() ?>" src="<?= FileHandler::getURL($video) ?>" controls poster="<?= videoPoster($video) ?>"></video>
<?php }

function eDataTypeToString(EDataType $type): void
{ ?>
    <?= ucwords(strtolower($type->name)) ?>
<?php }

function chipTag(Content $tag): void
{ ?>
    <a href="#" class="button"><?= $tag->getName() ?></a>
<?php }

function chipActor(Content $actor): void
{ ?>
    <a href="#" class="button"><?= $actor->getName() ?></a>
<?php }

function pagination(bool $displayMode): void
{ ?>
    <div class="row">
        <?php if ($displayMode) { ?>
            <div class="four columns">
                <button onclick="setParam('displayMode', 'table')" name="displayMode" id="displayMode-table">Table</button>
                <button onclick="setParam('displayMode', 'grid')" name="displayMode" id="displayMode-grid">Grid</button>
            </div>
        <?php } ?>
        <div id="pagination" class="<?= $displayMode ? 'four' : 'six' ?> columns">
            <button onclick="setParam('offset', 10)" name="offset" id="offset-10">◄</button>
            <button onclick="setParam('offset', 25)" name="offset" id="offset-25">5/10</button>
            <button onclick="setParam('offset', 50)" name="offset" id="offset-50">►</button>
        </div>
        <div class="<?= $displayMode ? 'four' : 'six' ?> columns">
            <button onclick="setParam('limit', 20)" name="limit" id="limit-20">20</button>
            <button onclick="setParam('limit', 50)" name="limit" id="limit-50">50</button>
            <button onclick="setParam('limit', 100)" name="limit" id="limit-100">100</button>
            <button onclick="setParam('limit', 200)" name="limit" id="limit-200">200</button>
            <button onclick="setParam('limit', 500)" name="limit" id="limit-500">500</button>
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

function gallery(Content $reference): void
{ ?>
    <div id="<?= $reference->getSlug() ?>-gallery" class="gallery">
        <div id="<?= $reference->getSlug() ?>-gallery-grid" class="gallery grid" style="column-count: 4">
            <?php $i = 0;
            foreach (Relation::getRelated($reference, EDataType::IMAGE) as $image) { ?>
                <img src="<?= FileHandler::getURL($image) ?>" onclick="showSlide(<?= ++$i ?>, '<?= $reference->getSlug() ?>-gallery')" alt="<?= $image->getName() ?>">
            <?php } ?>
        </div>
        <div id="<?= $reference->getSlug() ?>-gallery-modal" class="gallery modal">
            <div id="<?= $reference->getSlug() ?>-gallery-controls" class="gallery controls">1/100</div>
            <div id="<?= $reference->getSlug() ?>-gallery-slides" class="gallery slides">
                <?php $i = 0;
                foreach (Relation::getRelated($reference, EDataType::IMAGE) as $image) { ?>
                    <img src="<?= FileHandler::getURL($image) ?>" onclick="showSlide(<?= ++$i ?>, '<?= $reference->getSlug() ?>-gallery')" alt="<?= $image->getName() ?>">
                <?php } ?>
            </div>
            <div id="<?= $reference->getSlug() ?>-gallery-thumbnails" class="gallery thumbnails">
                <?php $i = 0;
                foreach (Relation::getRelated($reference, EDataType::IMAGE) as $image) { ?>
                    <img src="<?= FileHandler::getURL($image) ?>" onclick="showSlide(<?= ++$i ?>, '<?= $reference->getSlug() ?>-gallery')" alt="<?= $image->getName() ?>">
                <?php } ?>
            </div>
        </div>
    </div>
<?php }

function videoInfos(Content $reference): void
{ ?>
    <div id="video-<?= $reference->getId() ?>-info">
        <div class="row">
            <h1><?= $reference->getName() ?></h1>
        </div>
        <div class="row">
            <div class="six columns">
                <?php foreach (Relation::getRelated($reference, EDataType::ACTOR) as $actor) {
                    chipActor($actor);
                } ?>
            </div>
            <div class="six columns">
                <?php foreach (Relation::getRelated($reference, EDataType::TAG) as $tag) {
                    chipTag($tag);
                } ?>
            </div>
        </div>
        <div class="row">
            <div class="four columns">
                <?= $reference->getDateCreated()->format('d/m/Y') ?>
            </div>
            <div class="four columns">
                <?= $reference->getViews() . ' views' ?>
            </div>
            <div class="four columns">
                <a class="button" href="<?= App::getLink('edit', 'data=' . $reference->getId()) ?>" target="_blank">Edit</a>
            </div>
        </div>
    </div>
<?php }

function videoRelatedBy(Content $reference, EDataType $type, int $amount = -1): void
{
    foreach (Relation::getRelatedStepped($reference, $type, EDataType::VIDEO, $amount) as $video)
        videoLinkWithPoster($video);
}

function loadingPage(): void
{ ?>
    <div id="loadingPage">
        <span class="loader"></span>
    </div>
<?php }