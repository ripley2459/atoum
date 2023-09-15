<?php

require_once dirname(__DIR__, 2) . '/load.php';

R::require('id');

$content = new Content($_GET['id']);
$content = Content::get($_GET['id'], $content->getType());

?>

<form id="edit-modal-<?= $content->getId() ?>" class="modal open" onsubmit="event.preventDefault();" onkeydown="return event.key !== 'Enter';">
    <div class="content">
        <h1>Edit - <?= ucfirst(strtolower($content->getType()->name)) ?></h1>

        <div class="row">
            <div class="twelve columns">
                <label for="name">Name</label>
                <input class="u-full-width" type="text" placeholder="<?= $content->getName() ?>" value="<?= $content->getName() ?>" id="name-<?= $content->getId() ?>">
            </div>
        </div>

        <div class="row">
            <div class="six columns">
                <label for="date">Upload date</label>
                <input class="u-full-width" type="text" placeholder="<?= Blocks::formattedDate($content->getDateCreated()) ?>" value="<?= Blocks::formattedDate($content->getDateCreated()) ?>" id="date-<?= $content->getId() ?>">
            </div>

            <div class="six columns">
                <label for="views">Views</label>
                <input class="u-full-width" type="number" id="views-<?= $content->getId() ?>" min="0" value="<?= $content->getViews() ?>">
            </div>
        </div>

        <div class="row">
            <div class="six columns">
                <?= Blocks::searchData('actor-' . $content->getId(), 'Actors', 'actors...', EDataType::ACTOR, $content) ?>
            </div>
            <div class="six columns">
                <?= Blocks::searchData('tag-' . $content->getId(), 'Tags', 'tag...', EDataType::TAG, $content) ?>
            </div>
        </div>

        <div class="row">
            <div class="twelve columns">
                <div class="u-pull-right">
                    <button onclick="closeEdit()">Cancel</button>
                    <button onclick="applyEdit(['actor-<?= $content->getId() ?>[]','tag-<?= $content->getId() ?>[]'])" class="button-primary">Save</button>
                </div>
            </div>
        </div>

        <?php if ($content->getType() == EDataType::GALLERY) { ?>

            <div class="row">
                <div class="six columns">
                    <div class="row"></div>
                    <div class="row" id="linkedImages"></div>
                </div>
                <div class="six columns">
                    <div class="row">
                        <div class="twelve columns">
                            <label for="search">Search</label>
                            <input class="u-full-width" type="text" placeholder="search for..." id="filter-search" onkeyup="set('search', value)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="six columns">
                            <?= Blocks::buttonUrlParamSet('50', 'limit', 50) ?>
                            <?= Blocks::buttonUrlParamSet('100', 'limit', 100) ?>
                            <?= Blocks::buttonUrlParamSet('500', 'limit', 500) ?>
                            <?= Blocks::buttonUrlParamSet('1000', 'limit', 1000) ?>
                        </div>
                        <div id="pagination-edit" class="six columns"></div>
                    </div>
                    <div class="row" id="registeredImages"></div>
                </div>
            </div>

        <?php } else echo '<div>' . ($content instanceof Video ? $content->player() : $content->display()) . '</div>' ?>
    </div>
</form>