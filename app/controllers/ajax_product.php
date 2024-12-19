<?php

class Ajax_product extends Controller
{
    public function index()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        //var_dump(123);

        if (is_object($data) && isset($data->data_type)) {
            $DB = Database::newInstance();
            $product = $this->load_model('product');

            //show($data);

            if ($data->data_type == 'add_product') {
                //add new product
                $check = $product->create($data);

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
                    $arr['data'] = $product->make_table($products);
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
                $product->edit($data->id, $data->product);

                $arr['message'] = "Your product was updated!";
                $_SESSION['error'] = "";

                $arr['message_type'] = 'info';
                $arr['data_type'] = "edit_product";

                $cats = $product->get_all();
                $arr['data'] = $product->make_table($cats);

                echo json_encode($arr);
            }
        }
    }
}
