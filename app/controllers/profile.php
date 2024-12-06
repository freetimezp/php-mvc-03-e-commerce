<?php

class Profile extends Controller
{
    public function index()
    {
        $data['page_title'] = "Profile";

        $user = $this->load_model('user');
        $user_data = $user->check_login(true);

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        //show($data);
        $this->view("profile", $data);
    }
}
