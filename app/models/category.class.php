<?php

class Category
{
    public function create($DATA)
    {
        $db = Database::getInstance();

        $arr['category'] = ucwords($DATA->data);

        if (!preg_match('/^[a-zA-Z]+/', trim($arr['category']))) {
            $_SESSION['error'] = "Please, enter a valid category name.";
        }

        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "INSERT INTO categories (category) VALUES (:category)";
            $check = $db->write($query, $arr);

            if ($check) return true;
        }

        return false;
    }

    public function adit($data) {}

    public function delete($data) {}
}
