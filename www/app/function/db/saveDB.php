<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$path = path_CONTENT . 'backups/';
$file = $path . 'save_' . DBNAME . '_' . date('Y-m-d-H-i-s') . '.sql';
FileHandler::checkPath($path);

$mysqldump = MY_SQL_PATH;
$database = DBNAME;
$user = USER;
$pass = PASSWORD;
$host = HOST;

echo "<p>Backing up database to <code>{$file}</code></p>";

exec("{$mysqldump} --user={$user} --password={$pass} --host={$host} {$database} --result-file={$file} 2>&1", $output);

var_dump($output);