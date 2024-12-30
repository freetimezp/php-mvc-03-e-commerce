<?php

class Ajax_product extends Controller
{
    public function index()
    {
        if (count($_POST) > 0) {
            $data = (object)$_POST;
        } else {
            $data = file_get_contents("php://input");
        }



        if (is_object($data) && isset($data->data_type)) {
            $DB = Database::newInstance();
            $product = $this->load_model('product');
            $category = $this->load_model('category');
            $image_class = $this->load_model('image');

            //show($data);

            if ($data->data_type == 'add_product') {
                //add new product
                $check = $product->create($data, $_FILES, $image_class);

                if ($_SESSION['error'] != "") {
                    $arr['message'] = $_SESSION['error'];
                    $_SESSION['error'] = "";
                    $arr['message_type'] = 'error';

                    $arr['data'] = "";
                    $arr['data_type'] = "add_new";

                    echo json_encode($arr);
                } else {
                    $arr['message'] = 'product added successfully';
                    $arr['message_type'] = 'info';

                    $products = $product->get_all();
                    $arr['data'] = $product->make_table($products, $category);
                    $arr['data_type'] = "add_new";
                    //var_dump($products);

                    echo json_encode($arr);
                }
            } else if ($data->data_type == 'delete_row') {
                //delete product
                $product->delete($data->id);

                $arr['message'] = "Your product was deleted!";
                $_SESSION['error'] = "";

                $arr['message_type'] = 'info';
                $arr['data_type'] = "delete_row";

                $products = $product->get_all();
                $arr['data'] = $product->make_table($products);

                echo json_encode($arr);
            } else if ($data->data_type == 'disable_row') {
                //disable product
                $id = $data->id;
                $disabled = ($data->current_state == "Disabled") ? 0 : 1;

                $query = "UPDATE products SET disabled = '$disabled' WHERE id = '$id' LIMIT 1";
                $DB->write($query);

                $arr['message'] = "You activate or deactivate row!";
                $_SESSION['error'] = "";

                $arr['message_type'] = 'info';
                $arr['data_type'] = "disable_row";

                $cats = $product->get_all();
                $arr['data'] = $product->make_table($cats);

                echo json_encode($arr);
            } else if ($data->data_type == 'edit_product') {
                //edit product
                //var_dump($data);
                $product->edit($data, $_FILES);

                $arr['message'] = "Your product was updated!";
                $_SESSION['error'] = "";

                $arr['message_type'] = 'info';
                $arr['data_type'] = "edit_product";

                $cats = $product->get_all();
                $arr['data'] = $product->make_table($cats, $category);

                echo json_encode($arr);
            }
        }
    }
}
