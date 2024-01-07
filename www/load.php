<?php

/**
 * Configuration and Initialization Script
 * This script sets up essential constants, includes necessary files, and performs initializations required for the proper functioning of the application.
 */

define('URL', sprintf('%s://%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']));

const DIR = __DIR__ . '/';
const path_CLASS = DIR . 'app/class/';
const path_PUBLIC = DIR . 'public/';
const path_CONTENT = DIR . 'public/content/';

/**
 * As we do not use an autoloader, the files to integrate are listed here.
 */
require_once path_CLASS . 'R.php';
require_once path_CLASS . 'FileHandler.php';
require_once path_CLASS . 'RDB.php';
require_once path_CLASS . 'RDB_Where.php';
require_once path_CLASS . 'EDataType.php';
require_once path_CLASS . 'App.php';
require_once path_CLASS . 'Auth.php';
require_once path_CLASS . 'AData.php';
require_once path_CLASS . 'AContent.php';
require_once path_CLASS . 'User.php';
require_once path_CLASS . 'Content.php';
require_once path_CLASS . 'Relation.php';
require_once path_PUBLIC . 'include/Widgets.php';

if (file_exists(DIR . 'config.php')) {
    require_once DIR . 'config.php';
    RDB::start(['host' => HOST, 'dbname' => DBNAME, 'charset' => CHARSET, 'user' => USER, 'password' => PASSWORD, 'prefix' => PREFIX, 'sqlPath' => MY_SQL_PATH]);
} else {
    echo '<h1>Unable to reach website\'s settings!</h1>';
    die;
}

/**
 * Verification of the project arborescence as well as database tables.
 */
User::checkTable();
Content::checkTable();
Relation::checkTable();
FileHandler::checkPath(path_CONTENT);