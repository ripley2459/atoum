<?php

define('URL', sprintf('%s://%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']));

if (file_exists(__DIR__ . '/settings.php')) {
    require_once __DIR__ . '/settings.php';
    $dsn = 'mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=' . CHARSET;
    $dsn_options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => true];
    try {
        $DDB = new PDO($dsn, USER, PASSWORD, $dsn_options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
} else {
    echo '<h1>Unable to reach website\'s settings!</h1>';
    die;
}

const DIR = __DIR__;
const CONTENT = DIR . '/content/';
const INCLUDES = DIR . '/includes/';
const CLASSES = INCLUDES . 'classes/';
const PAGES = DIR . '/content/pages/';
const UPLOADS = CONTENT . 'uploads/';
const UPLOADS_URL = URL . '/content/uploads/';

require_once CLASSES . 'R.php';
require_once CLASSES . 'Logger.php';
require_once CLASSES . 'Builder.php';
require_once CLASSES . 'Request.php';
require_once CLASSES . 'FileHandler.php';
require_once CLASSES . 'IData.php';
require_once CLASSES . 'IFile.php';
require_once CLASSES . 'EDataType.php';
require_once CLASSES . 'EDataStatus.php';
require_once CLASSES . 'Setting.php';
require_once CLASSES . 'Blocks.php';
require_once CLASSES . 'ABlock.php';
require_once CLASSES . 'ABlockContainer.php';
require_once CLASSES . 'BlockTable.php';
require_once CLASSES . 'BlockGallery.php';
require_once CLASSES . 'Relation.php';
require_once CLASSES . 'Content.php';
require_once CLASSES . 'Image.php';
require_once CLASSES . 'Video.php';

Setting::checkTable();
Content::checkTable();
Relation::checkTable();