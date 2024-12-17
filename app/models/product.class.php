<?php

class Product
{
    public function create($DATA)
    {
        $db = Database::newInstance();

        $arr['description'] = ucwords($DATA->data);

        if (!preg_match('/^[a-zA-Z]+/', trim($arr['description']))) {
            $_SESSION['error'] = "Please, enter a valid description.";
        }

        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "INSERT INTO products (description) VALUES (:description)";
            $check = $db->write($query, $arr);

            if ($check) return true;
        }

        return false;
    }

    public function edit($id, $description)
    {
        $db = Database::newInstance();
        $arr['id'] = $id;
        $arr['description'] = $description;
        $query = "UPDATE products SET description = :description WHERE id = :id LIMIT 1";

        $db->write($query, $arr);
    }

    public function delete($id)
    {
        $db = Database::newInstance();
        $id = (int)$id;
        $query = "DELETE FROM products WHERE id = '$id' LIMIT 1";

        $db->write($query);
    }

    public function get_all()
    {
        $db = Database::newInstance();

        return $db->read("SELECT * FROM products ORDER BY id DESC");
    }

    public function make_table($cats)
    {
        //print_r($cats);

        $result = "";

        if (is_array($cats)) {
            foreach ($cats as $cat_row) {
                $class = $cat_row->disabled == 0 ? "success" : "warning";
                $cat_row->disabled = $cat_row->disabled ? "Disabled" : "Enabled";

                $args = $cat_row->id . ",'" . $cat_row->disabled . "'";
                $edit_args = $cat_row->id . ",'" . $cat_row->category . "'";

                $result .= "<tr>";
                $result .= '
                    <td><a href="basic_table.html"> ' . $cat_row->category . '</a></td>
                    <td>
                        <span 
                            class="label label-' . $class .  ' label-mini" 
                            style="cursor: pointer;" 
                            onclick="disable_row(' . $args . ')"> 
                            ' . $cat_row->disabled . ' 
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-xs" row_id="' . $cat_row->id  . '"
                            onclick="show_edit_category(' . $edit_args  . ', event)">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-xs" row_id="' . $cat_row->id . '"
                            onclick="delete_row(' . $cat_row->id  . ')">
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
