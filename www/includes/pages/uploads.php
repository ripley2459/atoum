<h1>Uploads</h1>

<div class="row">

    <div class="six columns">
        <label for="filesUploader">Upload</label>
        <input type="file" id="filesUploader" multiple required/>
        <button onclick="uploadFiles()">Upload!</button>
        <div id="informations" class="u-full-width"></div>
    </div>

    <div class="six columns">
        <label>Create</label>
        <a class="button" href="<?= URL . '/index.php?page=create&create=' . EDataType::GALLERY->value ?>"><?= ucfirst(strtolower(EDataType::GALLERY->name)) ?></a>
        <a class="button" href="<?= URL . '/index.php?page=create&create=' . EDataType::MENU->value ?>"><?= ucfirst(strtolower(EDataType::MENU->name)) ?></a>
    </div>

</div>

<div class="row">

    <div class="twelve columns">
        <label for="filter-search">Search</label>
        <input class="u-full-width" type="text" placeholder="search for..." id="filter-search" onkeyup="set('search', value)" value="<?= Builder::searchArgs()['search'] ?>">
    </div>

</div>

<div class="row">

    <div class="four columns">
        <?= Blocks::searchData('actor-filter', 'With actors', 'actors...', EDataType::ACTOR) ?>
    </div>

    <div class="four columns">
        <?= Blocks::searchData('tag-filter', 'With tags', 'tag...', EDataType::TAG) ?>
    </div>

    <div class="four columns">
        <label for="type">Type</label>
        <select class="u-full-width" id="type" onchange="set('type', value)">
            <option value="-1">All</option>
            <?php foreach (EDataType::cases() as $type) { ?>
                <option <?= $type->value == Builder::searchArgs()['type'] ? 'selected' : R::EMPTY ?> value="<?= $type->value ?>"> <?= ucfirst(strtolower($type->name)) ?></option>
            <?php } ?>
        </select>
    </div>

</div>

<div class="row">

    <div class="four columns">
        <?= Blocks::buttonUrlParamSet('10', 'limit', 10) ?>
        <?= Blocks::buttonUrlParamSet('50', 'limit', 50) ?>
        <?= Blocks::buttonUrlParamSet('100', 'limit', 100) ?>
        <?= Blocks::buttonUrlParamSet('500', 'limit', 500) ?>
        <?= Blocks::buttonUrlParamSet('1000', 'limit', 1000) ?>
    </div>

    <div id="pagination" class="four columns">
        <?= Blocks::buttonUrlParamSet('◄', 'limit', 10) ?>
        <?= Blocks::buttonUrlParamSet('25', 'limit', 25) ?>
        <?= Blocks::buttonUrlParamSet('►', 'limit', 50) ?>
    </div>

    <div class="four columns">
        <a class="button" href="<?= URL . '/index.php?page=uploads&display=0' ?>">Grid</a>
        <a class="button" href="<?= URL . '/index.php?page=uploads&display=1' ?>">Table</a>
    </div>

</div>

<div id="edit"></div>

<?php

$table = new BlockTable('uploads');
$bName = Blocks::buttonUrlParamToggle('Name', 'order', 'name_ASC', 'name_DESC');
$bType = Blocks::buttonUrlParamToggle('Type', 'order', 'type_ASC', 'type_DESC');
$bDate = Blocks::buttonUrlParamToggle('Date created', 'order', 'dateCreated_ASC', 'dateCreated_DESC');
$bShow = Blocks::buttonUrlParamToggle('Content', 'show', 'true', 'false');

if (Builder::searchArgs()['display'] == 1) {
    $table->dynamic();
    $table->addColumn($bName);
    $table->addColumn($bType);
    $table->addColumn($bDate);
    $table->addColumn('Views');
    $table->addColumn($bShow);
    $table->addColumn('Actions');
    echo $table->display();
} else {
    ?>
    <div class="row">
        <div class="one-third column"><?= $bName ?></div>
        <div class="one-third column"><?= $bType ?></div>
        <div class="one-third column"><?= $bDate ?></div>
    </div>
    <?php
    echo $table->TableLess();
} ?>