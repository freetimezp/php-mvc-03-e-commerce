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
        $countries = $this->load_model('countries');
        $data['countries'] = $countries->get_countries();


        //check if old post data exist
        if (isset($_SESSION['POST_DATA'])) {
            $data['POST_DATA'] =  $_SESSION['POST_DATA'];
        }

        if (count($_POST) > 0) {
            $order = $this->load_model('order');
            $order->validate($_POST);
            $data['errors'] = $order->errors;

            $_SESSION['POST_DATA'] = $_POST;
            $data['POST_DATA'] = $_POST;

            if (count($order->errors) == 0) {
                header("Location: " . ROOT . "checkout/summary");
                die;
            }
        }

        $this->view("checkout", $data);
    }


    public function summary()
    {
        $data['page_title'] = "Checkout Summary";

        $user = $this->load_model('user');
        $user_data = $user->check_login();

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
                $mytotal = $row->price * $row->cart_qty;
                $data['sub_total'] += $mytotal;
            }
        }

        $data['order_details'] = $rows;
        $data['orders'][] = $_SESSION['POST_DATA'];
        //show($data['user_data']);


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['POST_DATA'])) {
            $session_id = session_id();

            $user_url = "";
            if (isset($_SESSION['user_url'])) {
                $user_url = $_SESSION['user_url'];
            }

            $order = $this->load_model('order');
            $order->save_order($_SESSION['POST_DATA'], $rows, $user_url, $session_id);

            $data['errors'] = $order->errors;

            unset($_SESSION['POST_DATA']);
            unset($_SESSION['CART']);

            header("Location: " . ROOT . "checkout/thank_you");
            die;
        }

        $this->view("summary", $data);
    }


    public function thank_you()
    {
        $data['page_title'] = "Thank You";

        $user = $this->load_model('user');
        $user_data = $user->check_login();

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $this->view("checkout.thank_you", $data);
    }
}
