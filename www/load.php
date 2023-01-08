<?php

if (file_exists('settings.php')) {
    require_once __DIR__ . '/settings.php';
} else {
    header('Location: settings/install.php');
}

define('URL', sprintf('%s://%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']));

const DIR = __DIR__;
const INCLUDES = DIR . '/includes/';
const CONTENT = DIR . '/content/';
const SETTINGS = DIR . '/settings/';
const CLASSES = INCLUDES . 'classes/';
const INTERFACES = INCLUDES . 'interfaces/';
const WIDGETS = INCLUDES . 'widgets/';
const UPLOADS = CONTENT . 'uploads/';
const UPLOADS_URL = URL . '/content/uploads/';

require_once INTERFACES . 'IData.php';
require_once INTERFACES . 'IStatuable.php';

require_once CLASSES . 'Logger.php';
require_once CLASSES . 'Setting.php';
require_once CLASSES . 'FileHandler.php';
require_once CLASSES . 'PageBuilder.php';
require_once CLASSES . 'SettingsPageBuilder.php';
require_once CLASSES . 'ThemeHandler.php';
require_once CLASSES . 'Content.php';
require_once CLASSES . 'Gallery.php';
require_once CLASSES . 'Image.php';
require_once CLASSES . 'Movie.php';
require_once CLASSES . 'Playlist.php';
require_once CLASSES . 'Relation.php';
require_once CLASSES . 'Tag.php';
require_once CLASSES . 'User.php';
require_once CLASSES . 'Comment.php';

define('THEME', ThemeHandler::Instance()->getThemePath());