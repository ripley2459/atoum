<?php

/**
 * Configuration and Initialization Script
 * This script sets up essential constants, includes necessary files, and performs initializations required for the proper functioning of the application.
 */

define('URL', sprintf('%s://%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']));

const DIR = __DIR__ . '/';
const path_PUBLIC = DIR . 'public/';
const path_DATA = DIR . 'public/data/';

/**
 * As we do not use an autoloader, the files to integrate are listed here.
 */
require_once DIR . 'app/class/' . 'R.php';
require_once DIR . 'app/class/' . 'FileHandler.php';
require_once DIR . 'app/class/' . 'RDB.php';
require_once DIR . 'app/class/' . 'RDB_Where.php';
require_once DIR . 'app/class/' . 'EDataType.php';
require_once DIR . 'app/class/' . 'App.php';
require_once DIR . 'app/class/' . 'Auth.php';
require_once DIR . 'app/class/' . 'AData.php';
require_once DIR . 'app/class/' . 'AContent.php';
require_once DIR . 'app/class/' . 'User.php';
require_once DIR . 'app/class/' . 'Content.php';
require_once DIR . 'app/class/' . 'Relation.php';
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
FileHandler::checkPath(path_DATA);