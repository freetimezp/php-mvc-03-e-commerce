<?php

class Product
{
    public function create($DATA, $FILES, $image_class = null)
    {
        $db = Database::newInstance();

        $_SESSION['error'] = "";

        $arr['description'] = ucwords($DATA->description);
        $arr['quantity'] = $DATA->quantity;
        $arr['category'] = ucwords($DATA->category);
        $arr['price'] = $DATA->price;
        $arr['date'] = date("Y-m-d H:i:s");
        $arr['user_url'] = $_SESSION['user_url'];
        $arr['slag'] = $this->str_to_url($DATA->description);

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


        //make sure slag is unique
        $slag_arr = [];
        $slag_arr['slag'] = $arr['slag'];
        $query = "SELECT * FROM products WHERE slag = :slag LIMIT 1";
        $check = $db->read($query, $slag_arr);
        if ($check) {
            $arr['slag'] .= "-" . rand(0, 99999); //add random namber if slag exist in database
        };

        //check images
        $arr['image'] = "";
        $arr['image2'] = "";
        $arr['image3'] = "";
        $arr['image4'] = "";

        $allowed[] = "image/jpeg";
        $allowed[] = "image/png";
        $allowed[] = "image/gif";

        $folder = 'uploads/';
        $size = 1 * 1024 * 1024; //1 mb size

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        foreach ($FILES as $key => $img_row) {
            if ($img_row['error'] == 0 && in_array($img_row['type'], $allowed)) {
                if ($img_row['size'] < $size) {
                    $destination = $folder . $image_class->generate_filename(60) . ".jpg";
                    move_uploaded_file($img_row['tmp_name'], $destination);
                    $arr[$key] = $destination;

                    $image_class->resize_image($destination, $destination, 1500, 1500);
                } else {
                    $_SESSION['error'] .= "Image size must be less then 1 mb. <br>";
                }
            }
        }


        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "INSERT INTO products 
                (description, user_url, category, quantity, price, image, image2, image3, image4, date, slag)
                VALUES 
                (:description, :user_url, :category, :quantity, :price, :image, :image2, :image3, :image4, :date, :slag)";
            $check = $db->write($query, $arr);

            if ($check) return true;
        }

        return false;
    }

    public function edit($data, $FILES, $image_class = null)
    {
        $db = Database::newInstance();

        $arr['id'] = $data->id;
        $arr['description'] = $data->description;
        $arr['quantity'] = $data->quantity;
        $arr['category'] = $data->category;
        $arr['price'] = $data->price;

        $images_string = "";

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


        //check images
        $allowed[] = "image/jpeg";
        $allowed[] = "image/png";
        $allowed[] = "image/gif";

        $folder = 'uploads/';
        $size = 1 * 1024 * 1024; //1 mb size

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        foreach ($FILES as $key => $img_row) {
            if ($img_row['error'] == 0 && in_array($img_row['type'], $allowed)) {
                if ($img_row['size'] < $size) {
                    $destination = $folder . $image_class->generate_filename(60) . ".jpg";
                    move_uploaded_file($img_row['tmp_name'], $destination);
                    $arr[$key] = $destination;

                    $image_class->resize_image($destination, $destination, 1500, 1500);
                    $images_string .= "," . $key . " = :" . $key;
                } else {
                    $_SESSION['error'] .= "Image size must be less then 1 mb. <br>";
                }
            }
        }


        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "UPDATE products 
            SET description = :description, quantity = :quantity, category = :category, price = :price $images_string
            WHERE id = :id LIMIT 1";

            $db->write($query, $arr);
        }
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

    public function make_table($products, $model = null)
    {
        //print_r($products);

        $result = "";

        if (is_array($products)) {
            foreach ($products as $product_row) {
                $edit_args = $product_row->id . ",'" . $product_row->description . "'";

                $info = [];
                $info['id'] = $product_row->id;
                $info['description'] = $product_row->description;
                $info['category'] = $product_row->category;
                $info['quantity'] = $product_row->quantity;
                $info['price'] = $product_row->price;
                $info['image'] = $product_row->image;
                $info['image2'] = $product_row->image2;
                $info['image3'] = $product_row->image3;
                $info['image4'] = $product_row->image4;

                $info = json_encode($info);
                $info = str_replace('"', "'", $info); // for correct json reading in js

                $one_cat = $model->get_one($product_row->category);

                $result .= "<tr>";
                $result .= '
                    <td><a href="basic_table.html"> ' . $product_row->id . '</a></td>
                    <td><a href="basic_table.html"> ' . $product_row->description . '</a></td>
                    <td><a href="basic_table.html">
                        <img src= "' . ROOT . $product_row->image . '" style="width: 200px;" />
                    </a></td>
                    <td><a href="basic_table.html"> ' . $product_row->quantity . '</a></td>
                    <td><a href="basic_table.html"> ' . $one_cat->category . '</a></td>
                    <td><a href="basic_table.html"> ' . $product_row->price . '$ </a></td>
                    <td><a href="basic_table.html"> ' . date("jS M, Y", strtotime($product_row->date)) . '</a></td>

                    <td>
                        <button info="' . $info . '" class="btn btn-primary btn-xs" row_id="' . $product_row->id  . '"
                            onclick="show_edit_product(' . $edit_args  . ', event)">
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


    public function str_to_url($url)
    {
        $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
        $url = trim($url, '-');
        $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
        $url = strtolower($url);
        $url = preg_replace('~[^-a-z0-9_]+~', '', $url);

        return $url;
    }
}
