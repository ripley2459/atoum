<?php

define('URL', sprintf('%s://%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']));

if (file_exists(__DIR__ . '/settings.php')) {
    require_once __DIR__ . '/settings.php';
} else {
    header('Location: ' . URL . '/settings/install.php');
}

const DIR = __DIR__;
const SETTINGS = DIR . '/settings/';
const INCLUDES = DIR . '/includes/';
const CONTENT = DIR . '/content/';
const CLASSES = INCLUDES . 'classes/';
const ENUMERATIONS = INCLUDES . 'enumerations/';
const FUNCTIONS_URL = URL . '/includes/functions/';
const INTERFACES = INCLUDES . 'interfaces/';
const UPLOADS = CONTENT . 'uploads/';
const UPLOADS_URL = URL . '/content/uploads/';

require_once INCLUDES . 'functions.php';

require_once INTERFACES . 'IData.php';
require_once INTERFACES . 'IFile.php';

require_once ENUMERATIONS . 'EDataStatus.php';
require_once ENUMERATIONS . 'EDataType.php';

require_once CLASSES . 'Logger.php';
require_once CLASSES . 'Setting.php';
require_once CLASSES . 'RString.php';
require_once CLASSES . 'Researcher.php';
require_once CLASSES . 'FileHandler.php';
require_once CLASSES . 'ABlock.php';
require_once CLASSES . 'ABlockContainer.php';
require_once CLASSES . 'BlockSettings.php';
require_once CLASSES . 'AContent.php';
require_once CLASSES . 'PageBuilder.php';
require_once CLASSES . 'SettingsPageBuilder.php';
require_once CLASSES . 'ThemeHandler.php';
require_once CLASSES . 'Relation.php';
require_once CLASSES . 'Actor.php';
require_once CLASSES . 'Tag.php';
require_once CLASSES . 'Image.php';
require_once CLASSES . 'Gallery.php';
require_once CLASSES . 'Video.php';
require_once CLASSES . 'Playlist.php';
require_once CLASSES . 'Page.php';
require_once CLASSES . 'User.php';
require_once CLASSES . 'Comment.php';

define('THEME', ThemeHandler::Instance()->getThemePath());
define('THEME_URL', ThemeHandler::Instance()->getThemeURL());

require_once THEME . 'load.php';

const BLOCKS = [
    'BlockGrid',
    'BlockModal',
    'BlockPagination',
    'BlockGallery',
    'BlockCollapsible',
    'BlockSpinner0'
];

foreach (BLOCKS as $block) {
    require_once file_exists(THEME . 'includes/blocks/' . $block . '.php') ? THEME . 'includes/blocks/' . $block . '.php' : ThemeHandler::DefaultThemePath . 'includes/blocks/' . $block . '.php';
}