<?php

class Order extends Controller
{
    public $errors = array();

    public function save_order($POST, $rows, $user_url, $session_id)
    {

        foreach ($POST as $key => $value) {
            if ($key == "country") {
                if ($value == "" || $value == "-- Country --") {
                    $this->errors[] = "Please, choose a country from list..";
                }
            }

            if ($key == "state") {
                if ($value == "" || $value == "-- Choose state --") {
                    $this->errors[] = "Please, choose a state from list..";
                }
            }
        }

        //show($POST);
        $db = Database::newInstance();
        $data = array();

        $total = 0;
        foreach ($rows as $key => $row) {
            $total += $row->cart_qty * $row->price;
        }

        if (is_array($rows) && count($this->errors) == 0) {
            $countries = $this->load_model('countries');

            $data['user_url'] = $user_url;
            $data['session_id'] = $session_id;
            $data['delivery_address'] = $POST['address1'] . " " . $POST['address2'];
            $data['total'] = $total;
            $country_obj = $countries->get_country($POST['country']);
            $data['country'] = $country_obj->country;
            $state_obj = $countries->get_state($POST['state']);
            $data['state'] = $state_obj->state;
            $data['zip'] = $POST['postal_code'];
            $data['tax'] = 0;
            $data['shipping'] = 0;
            $data['date'] = date("Y-m-d H:i:s");
            $data['home_phone'] = $POST['home_phone'];
            $data['mobile_phone'] = $POST['mobile_phone'];

            $query = "INSERT INTO orders 
                (user_url, delivery_address, total, country, state, zip, tax, shipping,
                    date, session_id, home_phone, mobile_phone) 
                VALUES (:user_url, :delivery_address, :total, :country, :state, :zip, :tax, :shipping,
                    :date, :session_id, :home_phone, :mobile_phone)";

            $result = $db->write($query, $data);


            //save order details
            $order_id = 0;
            $query = "SELECT id FROM orders order by id DESC LIMIT 1";
            $result = $db->read($query);

            if (is_array($result)) {
                $order_id = $result[0]->id;
            }

            foreach ($rows as $row) {
                $data = array();
                $data['order_id'] = $order_id;
                $data['qty'] = $row->cart_qty;
                $data['description'] = $row->description;
                $data['amount'] = $row->price;
                $data['total'] = $row->cart_qty * $row->price;
                $data['product_id'] = $row->id;

                $query = "INSERT INTO order_details (order_id, qty, description, amount, total, product_id) 
                    VALUES (:order_id, :qty, :description, :amount, :total, :product_id)";
                $result = $db->write($query, $data);
            }
        }
    }


    public function get_orders_by_user($user_url)
    {
        $orders = false;

        $db = Database::newInstance();
        $data['user_url'] = $user_url;

        $query = "SELECT * FROM orders WHERE user_url = :user_url ORDER BY id DESC LIMIT 100";
        $orders = $db->read($query, $data);

        return $orders;
    }


    public function get_all_orders()
    {
        $orders = false;

        $db = Database::newInstance();

        $query = "SELECT * FROM orders ORDER BY id DESC LIMIT 100";
        $orders = $db->read($query);

        return $orders;
    }
}
