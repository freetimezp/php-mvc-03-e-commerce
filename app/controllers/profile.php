<?php

class Profile extends Controller
{
    public function index()
    {
        $data['page_title'] = "Profile";

        $user = $this->load_model('user');
        $order = $this->load_model('order');

        $user_data = $user->check_login(true);

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $orders = $order->get_orders_by_user($user_data->url_address);
        //show($orders);

        if (is_array($orders)) {
            $data['orders'] = $orders;
        }

        //show($data);
        $this->view("profile", $data);
    }
}
