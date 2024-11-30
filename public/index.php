<?php

session_start();

$path_root = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
//echo ($path_root);

define('ROOT', $path_root);
define('TEMPLATE', "eshop");
define('ASSETS', $path_root . "assets/");
define('ASSETS_TEMPLATE', $path_root . "assets/" . TEMPLATE . "/");
//echo (ASSETS);

include("../app/init.php");

$app = new App();
