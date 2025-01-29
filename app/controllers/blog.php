<?php

class Blog extends Controller
{
    public function index()
    {
        //pagination
        $limit = 2;
        $offset = Page::get_offset($limit);

        //check if we use search
        $search = false;
        $find = "";
        $show_search = true;

        $DB = Database::newInstance();

        if (isset($_GET['find'])) {
            $search = true;
            $find = addslashes($_GET['find']);
        }

        $data['page_title'] = "Blog";

        $user = $this->load_model('user');
        $user_data = $user->check_login();

        $image_class = $this->load_model('image');

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }


        $rows = false;
        if ($search && !empty($find)) {
            $arr['title'] = "%" . $find . "%";
            $rows = $DB->read("SELECT * FROM blogs WHERE title LIKE :title LIMIT $limit OFFSET $offset", $arr);
        } else {
            $rows = $DB->read("SELECT * FROM blogs ORDER BY id DESC LIMIT $limit OFFSET $offset");
        }

        if ($rows) {
            foreach ($rows as $key => $row) {
                $rows[$key]->image = $image_class->get_thumb_blog_post($rows[$key]->image);
                $rows[$key]->author_data = $user->get_user($rows[$key]->user_url);
            }
        }

        //get all categories
        $category = $this->load_model('category');
        $categories = $category->get_all();
        if ($categories) {
            $data['categories'] = $categories;
        }


        $data['rows'] = $rows;
        $data['show_search'] = $show_search;

        //show($data);
        $this->view("blog", $data);
    }
}
