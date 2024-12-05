<?php

class Admin extends Controller
{
    public function index()
    {
        $data['page_title'] = "Admin";

        $user = $this->load_model('user');
        $user_data = $user->check_login();

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        //show($data);
        $this->view("admin/index", $data);
    }
}
