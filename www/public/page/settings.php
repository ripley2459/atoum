<?php if (!Auth::isLoggedIn())
    App::redirect('home'); ?>

<div class="container">
    <h1>Settings</h1>
    <!-- Temporary system for testing and automation! -->
    <div class="row">
        <button onclick="saveDB()">Save DB</button>
        <?php foreach (R::recursiveScan(path_CONTENT . 'scripts/') as $script) {
            if (str_contains($script, 'disabled'))
                continue;
            $script = str_replace(path_CONTENT . 'scripts/', R::EMPTY, $script);
            $script = str_replace('.php', R::EMPTY, $script); ?>
            <button onclick="putFrom('<?= URL . '/public/content/scripts/' . $script ?>.php', 'settingsFeedbacks')"><?= $script ?></button>
        <?php } ?>
    </div>
    <div id="settingsFeedbacks"></div>
</div>