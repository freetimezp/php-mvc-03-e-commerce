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

    public function get_all()
    {
        $db = Database::newInstance();

        return $db->read("SELECT * FROM categories ORDER BY id DESC");
    }

    public function make_table($cats)
    {
        //print_r($cats);

        $result = "";

        if (is_array($cats)) {

            foreach ($cats as $cat_row) {
                $result .= "<tr>";
                $result .= '
                    <td><a href="basic_table.html"> ' . $cat_row->category . '</a></td>
                    <td><span class="label label-info label-mini">' . $cat_row->disabled . '</span></td>
                    <td>
                        <button class="btn btn-success btn-xs">
                            <i class="fa fa-check"></i>
                        </button>
                        <button class="btn btn-primary btn-xs">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-xs">
                            <i class="fa fa-trash-o "></i>
                        </button>
                    </td>     
                ';

                $result .= "</tr>";
            }
        }

        return $result;
    }
}
