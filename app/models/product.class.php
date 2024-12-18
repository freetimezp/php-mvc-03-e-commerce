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

    public function make_table($products)
    {
        //print_r($products);

        $result = "";

        if (is_array($products)) {
            foreach ($products as $product_row) {
                $edit_args = $product_row->id . ",'" . $product_row->description . "'";

                $result .= "<tr>";
                $result .= '
                    <td><a href="basic_table.html"> ' . $product_row->description . '</a></td>
                    <td>
                        <span> 
                            
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-xs" row_id="' . $product_row->id  . '"
                            onclick="show_edit_productegory(' . $edit_args  . ', event)">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-xs" row_id="' . $product_row->id . '"
                            onclick="delete_row(' . $product_row->id  . ')">
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
