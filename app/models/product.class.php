<?php

class Product
{
    public function create($DATA)
    {
        $db = Database::newInstance();

        $_SESSION['error'] = "";

        $arr['description'] = ucwords($DATA->description);
        $arr['quantity'] = $DATA->quantity;
        $arr['category'] = ucwords($DATA->category);
        $arr['price'] = $DATA->price;
        $arr['date'] = date("Y-m-d H:i:s");
        $arr['user_url'] = $_SESSION['user_url'];

        if (!preg_match('/^[a-zA-Z0-9 _-]+/', trim($arr['description']))) {
            $_SESSION['error'] .= "Please, enter a valid description. <br>";
        }

        if (!is_numeric($arr['quantity'])) {
            $_SESSION['error'] .= "Please, enter a valid quantity. <br>";
        }

        if (!is_numeric($arr['category'])) {
            $_SESSION['error'] .= "Please, choose category from the list. <br>";
        }

        if (!is_numeric($arr['price'])) {
            $_SESSION['error'] .= "Please, enter a valid price. <br>";
        }

        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "INSERT INTO products 
                (description, user_url, category, quantity, price, date)
                VALUES (:description, :user_url, :category, :quantity, :price, :date)";
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
