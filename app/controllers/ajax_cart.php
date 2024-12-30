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
}
