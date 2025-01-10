<?php

class Profile extends Controller
{
    public function index($url_address = null)
    {
        $data['page_title'] = "Profile";

        $user = $this->load_model('user');
        $order = $this->load_model('order');

        $orders = false;

        $user_data = $user->check_login(true);
        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        if ($url_address) {
            $profile_data = $user->get_user($url_address);
        } else {
            $profile_data = $user_data;
        }

        if (is_object($profile_data)) {
            $data['profile_data'] = $profile_data;
            $orders = $order->get_orders_by_user($profile_data->url_address);
        }



        if (is_array($orders)) {

            foreach ($orders as $key => $row) {
                # code...
                $details = $order->get_order_details($row->id);
                if ($details) {
                    $totals = array_column($details, 'total');
                    $grand_total = array_sum($totals);

                    $orders[$key]->details = $details;
                    $orders[$key]->grand_total = $grand_total;
                }
            }

            //show($orders);
            $data['orders'] = $orders;
        }


        $this->view("profile", $data);
    }
}
