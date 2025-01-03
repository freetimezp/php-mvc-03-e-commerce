<?php

class Checkout extends Controller
{
    public function index()
    {
        $data['page_title'] = "Checkout";

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

        if (is_array($rows)) {
            rsort($rows);
        }

        $data['rows'] = $rows;
        //show($data);

        //get countries
        $country = $this->load_model('country');
        $data['countries'] = $country->get_countries();

        if (count($_POST) > 0) {
            //show($_POST);
            //show($rows);
            //show($_SESSION);

            $session_id = session_id();

            $user_url = "";
            if (isset($_SESSION['user_url'])) {
                $user_url = $_SESSION['user_url'];
            }

            $order = $this->load_model('order');
            $order->save_order($_POST, $rows, $user_url, $session_id);

            //header("Location: " . ROOT . "thank_you");
            //die;
        }

        $this->view("checkout", $data);
    }
}
