<?php

class Category
{
    public function create($DATA)
    {
        $db = Database::newInstance();

        $arr['category'] = ucwords($DATA->category);
        $arr['parent'] = ucwords($DATA->parent);

        if (!preg_match('/^[a-zA-Z]+/', trim($arr['category']))) {
            $_SESSION['error'] = "Please, enter a valid category name.";
        }

        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "INSERT INTO categories (category, parent) VALUES (:category, :parent)";
            $check = $db->write($query, $arr);

            if ($check) return true;
        }

        return false;
    }

    public function edit($data)
    {
        $db = Database::newInstance();
        $arr['id'] = $data->id;
        $arr['category'] = $data->category;
        $arr['parent'] = $data->parent;
        $query = "UPDATE categories SET category = :category, parent = :parent WHERE id = :id LIMIT 1";

        $db->write($query, $arr);
    }

    public function delete($id)
    {
        $db = Database::newInstance();
        $id = (int)$id;
        $query = "DELETE FROM categories WHERE id = '$id' LIMIT 1";

        $db->write($query);
    }

    public function get_all()
    {
        $db = Database::newInstance();

        return $db->read("SELECT * FROM categories ORDER BY id DESC");
    }

    public function get_one($id)
    {
        $id = (int)$id;
        $db = Database::newInstance();

        $data = $db->read("SELECT * FROM categories WHERE id = '$id' LIMIT 1");

        return $data[0];
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

                $parent = "";
                foreach ($cats as $cat_row2) {
                    if ($cat_row->parent == $cat_row2->id) {
                        $parent = $cat_row2->category;
                    }
                }

                $result .= "<tr>";
                $result .= '
                    <td><a href="basic_table.html"> ' . $cat_row->category . '</a></td>
                    <td><a href="basic_table.html"> ' . $parent . '</a></td>
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
