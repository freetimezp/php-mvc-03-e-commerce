<?php

class Add_to_cart extends Controller
{
    public function index($id = '')
    {
        $id = esc($id);

        $DB = Database::newInstance();
        $rows = $DB->read("SELECT * FROM products WHERE id = :id LIMIT 1", ['id' => $id]);

        if ($rows) {
            $row = $rows[0];

            if (isset($_SESSION['CART'])) {
                $ids = array_column($_SESSION['CART'], "id");
                if (in_array($row->id, $ids)) {
                    $key = array_search($row->id, $ids);
                    $_SESSION['CART'][$key]['qty']++;
                } else {
                    $arr = array();
                    $arr['id'] = $row->id;
                    $arr['qty'] = 1;

                    $_SESSION['CART'][] = $arr;
                }
            } else {
                $arr = array();
                $arr['id'] = $row->id;
                $arr['qty'] = 1;

                $_SESSION['CART'][] = $arr;
            }
        }


        //header("Location: " . ROOT . "shop");
    }
}
