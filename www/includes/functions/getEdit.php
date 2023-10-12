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

        <?php if ($content->getType() != EDataType::MENU) { ?>
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
                <?php if ($content->getType() != EDataType::ACTOR){ ?>
                <div class="six columns">
                    <?= Blocks::searchData('actor-' . $content->getId(), 'Actors', 'actors...', EDataType::ACTOR, $content) ?>
                </div>
                <div class="six columns">
                    <?php } ?>
                    <?= Blocks::searchData('tag-' . $content->getId(), 'Tags', 'tag...', EDataType::TAG, $content) ?>
                    <?php if ($content->getType() != EDataType::ACTOR){ ?>
                </div>
            <?php } ?>
            </div>
        <?php } ?>

        <div class="row">
            <div class="twelve columns">
                <?php if ($content->getType() == EDataType::VIDEO) { ?>
                    <button class="u-pull-left" onclick="setPreview('<?= $content->getSlug() ?>', <?= $content->getId() ?>)">Set preview</button>
                    <canvas id="<?= $content->getSlug() ?>-canvas" class="thumbnail-canvas"></canvas>
                <?php } ?>
                <div class="u-pull-left">
                    <button onclick="unregister(<?= $content->getId() ?>,<?= $content->getType()->value ?>)">Delete</button>
                </div>
                <div class="u-pull-right">
                    <button onclick="closeEdit()">Cancel</button>
                    <button onclick="applyEdit(['actor-<?= $content->getId() ?>[]','tag-<?= $content->getId() ?>[]'])" class="button-primary">Save</button>
                </div>
            </div>
        </div>

        <div id="feedbacks"></div>

        <?php if ($content->getType() == EDataType::GALLERY) { ?>

            <div class="row">
                <div class="six columns">
                    <div class="row"></div>
                    <div class="rowgrid fake-container" style="column-count: 5" id="linkedImages"></div>
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
                    <div id="registeredImages" class="row grid fake-container" style="column-count: 5"></div>
                </div>
            </div>

        <?php } else echo '<div>' . ($content instanceof Video ? $content->player() : $content->display()) . '</div>' ?>
    </div>
</form>