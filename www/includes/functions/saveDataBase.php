<?php

require_once dirname(__DIR__, 2) . '/load.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$path = CONTENT . 'backups/';
$file = $path . 'save_' . DBNAME . '_' . date('Y-m-d-H-i-s') . '.sql';
FileHandler::checkPath($path);

$mysqldump = 'C:\wamp64\bin\mysql\mysql8.0.31\bin' . '\mysqldump';
$database = DBNAME;
$user = USER;
$pass = PASSWORD;
$host = HOST;

echo "<p>Backing up database to <code>{$file}</code></p>";

exec("{$mysqldump} --user={$user} --password={$pass} --host={$host} {$database} --result-file={$file} 2>&1", $output);

var_dump($output);