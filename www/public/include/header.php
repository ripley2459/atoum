<?php loadingPage() ?>
<div id="header">
    <div class="wrapper">
        <div id="topLogo">
            <img src="<?= App::include('logo.png') ?>" alt="logo.png">
        </div>
        <nav id="topNav">
            <div class="item">
                <a href="<?= App::getLink('home') ?>">Home</a>
            </div>
            <div class="item">
                <a href="<?= App::getLink('uploads') ?>">Uploads</a>
            </div>
            <div class="item">
                <a href="<?= App::getLink('settings') ?>">Settings</a>
            </div>
            <div class="item">
                <a href="<?= App::getLink('login') ?>">Login</a>
            </div>
        </nav>
    </div>
</div>
<?php notifications() ?>
<div id="content">