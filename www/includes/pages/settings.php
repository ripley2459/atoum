<h1>Settings</h1>

<!-- Temporary system for testing and automation! -->
<div class="row">
    <button onclick="<?= R::createFunctionJS('putFrom', URL . '/includes/functions/saveDataBase.php', 'feedbacks') ?>">Save DB</button>
    <?php foreach (R::recursiveScan(CONTENT . 'scripts/') as $script) {
        $script = str_replace(CONTENT . 'scripts/', R::EMPTY, $script);
        $script = str_replace('.php', R::EMPTY, $script);
        ?>
        <button onclick="<?= R::createFunctionJS('putFrom', URL . '/content/scripts/' . $script, 'feedbacks') ?>"><?= $script ?></button>
    <?php } ?>
</div>

<div id="feedbacks" class="u-full-width"></div>