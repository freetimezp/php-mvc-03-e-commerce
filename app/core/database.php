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

        return $instance = new self();
    }

    public static function newInstance()
    {
        return $instance = new self();
    }


    //read from db
    public function read($query, $arr = [])
    {
        $stm = self::$con->prepare($query);
        $result = $stm->execute($arr);

        if ($result) {
            $data = $stm->fetchAll(PDO::FETCH_OBJ);

            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }

        return false;
    }

    //write to db
    public function write($query, $arr = [])
    {
        $stm = self::$con->prepare($query);
        $result = $stm->execute($arr);

        if ($result) {
            return true;
        }

        return false;
    }


    public function query($query, $data = [])
    {
        $con = Database::getInstance();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result;
            }
        }

        return false;
    }
}

//$db = Database::getInstance();
//show($db);
