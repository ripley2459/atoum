</div>
<div id="footer">
    <div id="bottomNav">
        <a href="<?= URL ?>">Home</a>
        <a href="<?= URL . '/settings/index.php?page=settings' ?>">Settings</a>
        <a href="https://github.com/ripley2459/atoum">About</a>
    </div>
    <script src="<?= URL . '/includes/scripts.js' ?>"></script>
    <?php SettingsPageBuilder::Instance()->displayScripts() ?>
</div>
<?php
    $toTopButton = new BlockToTop();
    echo $toTopButton->display();
?>
</body>
</html>