<?php

class Order
{
    public function save_order($POST, $rows, $user_url, $session_id)
    {
        show($POST);
        $db = Database::newInstance();
        $data = array();

        $total = 0;
        foreach ($rows as $key => $row) {
            $total += $row->cart_qty * $row->price;
        }

        if (is_array($rows)) {
            $data['user_url'] = $user_url;
            $data['session_id'] = $session_id;
            $data['delivery_address'] = $POST['address1'] . " " . $POST['address2'];
            $data['total'] = $total;
            $data['country'] = $POST['country'];
            $data['state'] = $POST['state'];
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
        }
    }
}