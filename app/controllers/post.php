<?php

class Post extends Controller
{
    public function index($url_address = '')
    {
        //check if we use search
        $search = false;
        $find = "";
        $show_search = true;
        $arr = array();

        $DB = Database::newInstance();

        if (isset($_GET['find'])) {
            $search = true;
            $find = addslashes($_GET['find']);
        }

        $data['page_title'] = "Single Post";

        $user = $this->load_model('user');
        $user_data = $user->check_login();

        $image_class = $this->load_model('image');

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $rows = false;
        if ($search && !empty($find)) {
            $arr['title'] = "%" . $find . "%";
            $rows = $DB->read("SELECT * FROM blogs WHERE title LIKE :title ORDER BY id DESC", $arr);
        } else {
            $arr['url_address'] = $url_address;
            $rows = $DB->read("SELECT * FROM blogs WHERE url_address = :url_address LIMIT 1", $arr);
        }

        if ($rows) {
            $data['page_title'] = " - " . $rows[0]->title;
            //$rows[0]->image = $image_class->get_thumb_blog_post($rows[0]->image);
            $rows[0]->author_data = $user->get_user($rows[0]->user_url);
        }

        //get all categories
        $category = $this->load_model('category');
        $categories = $category->get_all();
        if ($categories) {
            $data['categories'] = $categories;
        }

        $data['row'] = $rows[0];
        $data['show_search'] = $show_search;

        //show($data);
        $this->view("single_post", $data);
    }
}
