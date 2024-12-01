<?php

class Database
{
    public static $con;

    public function __construct()
    {
        try {
            //code...
            $string = DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";";
            self::$con = new PDO($string, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            //throw $e;
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$con) {
            return self::$con;
        }

        $a = new self();

        return self::$con;
    }
}

$db = Database::getInstance();
//show($db);
