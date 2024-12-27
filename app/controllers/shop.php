<?php

class Shop extends Controller
{
    public function index()
    {
        $data['page_title'] = "Shop";

        $user = $this->load_model('user');
        $user_data = $user->check_login();

        $image_class = $this->load_model('image');

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $DB = Database::newInstance();
        $rows = $DB->read("SELECT * FROM products ORDER BY id DESC");

        if ($rows) {
            foreach ($rows as $key => $row) {
                $rows[$key]->image = $image_class->get_thumb_post($rows[$key]->image);
            }
        }

        $data['rows'] = $rows;

        //show($data);
        $this->view("shop", $data);
    }
}
