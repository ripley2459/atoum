<h1>Settings</h1>
<div>
    <div class="row">
        <div class="twelve columns">
            <label>Save DB</label>
            <button onclick="<?= R::createFunctionJS('getFrom', URL . '/includes/functions/saveDataBase.php', 'informations') ?>">Save DB</button>
            <div id="informations" class="u-full-width"></div>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns">
            <label>Restore values</label>
            <button onclick="<?= R::createFunctionJS('getFrom', URL . '/includes/functions/restoreOld.php', 'informations-old') ?>">Restore values</button>
            <div id="informations-old" class="u-full-width"></div>
        </div>
    </div>
</div>