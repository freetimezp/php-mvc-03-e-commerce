<?php

class Shop extends Controller
{
    public function index()
    {
        //pagination
        $limit = 6;
        $page_number = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
        $page_number = $page_number < 1 ? 1 : $page_number;
        $offset = ($page_number - 1) * $limit;

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
            $query = "SELECT * FROM products WHERE description LIKE :description LIMIT $limit OFFSET $offset ORDER BY id DESC";
            $rows = $DB->read($query, $arr);
        } else {
            $query = "SELECT * FROM products LIMIT $limit OFFSET $offset";
            $rows = $DB->read($query);
        }

        if ($rows) {
            foreach ($rows as $key => $row) {
                $rows[$key]->image = $image_class->get_thumb_post($rows[$key]->image);
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
        $this->view("shop", $data);
    }


    public function category($cat_name = '')
    {
        //pagination
        $limit = 6;

        $offset = Page::get_offset($limit);

        $DB = Database::newInstance();

        $user = $this->load_model('user');
        $image_class = $this->load_model('image');
        $Category = $this->load_model('category');

        $user_data = $user->check_login();
        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $arr = false;
        $rows = array();
        $cat_arr_children = false;

        //get all categories
        $categories = $Category->get_all();
        if ($categories) {
            $data['categories'] = $categories;
        }

        $cat_id = null;
        $check = $Category->get_one_by_name($cat_name);
        //show($check);
        if (is_object($check)) {
            $cat_id = $check->id;
            $arr['cat_id'] = $cat_id;

            foreach ($categories as $row) {
                if ($row->parent == $check->id) {
                    $cat_arr_children[] = $row->id;
                }
            }
        }

        //get products by category
        if (empty($cat_arr_children)) {
            $query = "SELECT * FROM products WHERE category = :cat_id LIMIT $limit OFFSET $offset ORDER BY id DESC";
            $rows = $DB->read($query, $arr);
        } else {
            foreach ($cat_arr_children as $key => $row) {
                $arr['cat_id'] = $row;
                $query = "SELECT * FROM products WHERE category = :cat_id LIMIT $limit OFFSET $offset ORDER BY id DESC";
                $rows2 = $DB->read($query, $arr);
                if (is_array($rows2)) {
                    $rows = array_merge($rows, $rows2);
                }
            }
        }
        //show($rows);

        if ($rows) {
            foreach ($rows as $key => $row) {
                $rows[$key]->image = $image_class->get_thumb_post($rows[$key]->image);
            }
        }

        $data['page_title'] = "Shop";
        $data['rows'] = $rows;
        $data['show_search'] = true;


        $this->view("shop", $data);
    }
}
