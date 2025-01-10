<?php

class Shop extends Controller
{
    public function index()
    {
        //check if we use search
        $search = false;
        $find = "";
        $show_search = true;

        if (isset($_GET['find'])) {
            $search = true;
            $find = addslashes($_GET['find']);
        }

        $data['page_title'] = "Shop";

        $user = $this->load_model('user');
        $user_data = $user->check_login();

        $image_class = $this->load_model('image');

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $DB = Database::newInstance();

        $rows = false;
        if ($search && !empty($find)) {
            $arr['description'] = "%" . $find . "%";
            $rows = $DB->read("SELECT * FROM products WHERE description LIKE :description ORDER BY id DESC", $arr);
        } else {
            $rows = $DB->read("SELECT * FROM products ORDER BY id DESC");
        }

        if ($rows) {
            foreach ($rows as $key => $row) {
                $rows[$key]->image = $image_class->get_thumb_post($rows[$key]->image);
            }
        }

        $data['rows'] = $rows;
        $data['show_search'] = $show_search;

        //show($data);
        $this->view("shop", $data);
    }
}
