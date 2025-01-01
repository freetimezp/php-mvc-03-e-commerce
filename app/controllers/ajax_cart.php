<?php

class Ajax_cart extends Controller
{
    public function index() {}

    public function edit_quantity($data = '')
    {
        $obj = json_decode($data);

        $id = esc($obj->id);
        $qty = esc($obj->quantity);

        if (isset($_SESSION['CART'])) {
            foreach ($_SESSION['CART'] as $key => $item) {
                if ($item['id'] == $id) {
                    $_SESSION['CART'][$key]['qty'] = (int)$qty;
                    break;
                }
            }
        }

        $obj->data_type = "edit_quantity";

        echo json_encode($obj);
    }


    public function delete_item($data = '')
    {
        $obj = json_decode($data);

        $id = esc($obj->id);

        if (isset($_SESSION['CART'])) {
            foreach ($_SESSION['CART'] as $key => $item) {
                if ($item['id'] == $id) {
                    unset($_SESSION['CART'][$key]);
                    $_SESSION['CART'] = array_values($_SESSION['CART']);
                    break;
                }
            }
        }

        $obj->data_type = "delete_item";

        echo json_encode($obj);
    }
}
