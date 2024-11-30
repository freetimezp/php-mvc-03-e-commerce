<?php

//path
$path_root = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
define('ROOT', $path_root);
define('TEMPLATE', "eshop");
define('ASSETS', $path_root . "assets/");
define('ASSETS_TEMPLATE', $path_root . "assets/" . TEMPLATE . "/");

//title
define('WEBSITE_TITLE', "Project | MVC | E-Shop");

//database
define('DB_NAME', 'eshop_db');
define('DB_USER', 'root');
define('DB_PASS', '');

//debug
define("DEBUG", true);

if (DEBUG) {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}
