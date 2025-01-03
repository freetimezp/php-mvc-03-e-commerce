<?php

class Cart extends Controller
{
    public function index()
    {
        $data['page_title'] = "Cart";

        $user = $this->load_model('user');
        $user_data = $user->check_login();

        $image_class = $this->load_model('image');

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $DB = Database::newInstance();
        $rows = false;

        $prod_ids = array();
        if (isset($_SESSION['CART'])) {
            $prod_ids = array_column($_SESSION['CART'], 'id');
            //covert to string
            $ids_str = "'" . implode("','", $prod_ids) . "'";

            $rows = $DB->read("SELECT * FROM products WHERE id IN ($ids_str) ORDER BY id DESC");
        }

        //show($rows);
        if (is_array($rows)) {
            foreach ($rows as $key => $row) {
                foreach ($_SESSION['CART'] as $item) {
                    if ($row->id == $item['id']) {
                        $rows[$key]->cart_qty = $item['qty'];
                        break;
                    }
                }
            }
        }

        //show($rows);
        $data['sub_total'] = 0;

        if ($rows) {
            foreach ($rows as $key => $row) {
                $rows[$key]->image = $image_class->get_thumb_post($rows[$key]->image);
                $mytotal = $row->price * $row->cart_qty;

                $data['sub_total'] += $mytotal;
            }
        }

        if ($rows) {
            rsort($rows);
        }

        $data['rows'] = $rows;

        //show($data);
        $this->view("cart", $data);
    }
}
