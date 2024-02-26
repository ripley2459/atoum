<?php if (!Auth::isLoggedIn())
    App::redirect('home');

App::setTitle('Atoum - Settings');
App::setDescription('Atoum - Settings'); ?>

<div class="container settings">
    <h1>Settings</h1>
    <!-- Temporary system for testing and automation! -->
    <div class="row u-space-bot">
        <button onclick="saveDB('settingsFeedbacks')">Save DB</button>
        <?php foreach (R::recursiveScan(path_DATA . 'scripts/') as $script) {
            if (str_contains($script, 'disabled'))
                continue;
            $script = str_replace(path_DATA . 'scripts/', R::EMPTY, $script);
            $script = str_replace('.php', R::EMPTY, $script); ?>
            <button onclick="putFrom('<?= URL . '/public/data/scripts/' . $script ?>.php', 'settingsFeedbacks')"><?= $script ?></button>
        <?php } ?>
    </div>
    <div id="settingsFeedbacks"></div>
</div>