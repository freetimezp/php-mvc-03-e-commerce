<?php

//path
$path_root = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
$path_root = str_replace("index.php", "", $path_root);

define('ROOT', $path_root);
define('THEME', 'eshop/');
define('ASSETS', $path_root . "assets/");


//title
define('WEBSITE_TITLE', "Project | MVC | E-Shop");


//database
define('DB_NAME', 'eshop_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');

//debug
define("DEBUG", true);

if (DEBUG) {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}
