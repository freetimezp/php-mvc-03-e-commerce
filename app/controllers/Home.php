<?php

class Home extends Controller
{
    public function index()
    {
        //check if we use search
        $search = false;
        $find = "";
        $show_search = true;

        $DB = Database::newInstance();

        if (isset($_GET['find'])) {
            $search = true;
            $find = addslashes($_GET['find']);
        }

        $data['page_title'] = "Home";

        $user = $this->load_model('user');
        $user_data = $user->check_login();

        $image_class = $this->load_model('image');

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }


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

        //get all categories
        $category = $this->load_model('category');
        $categories = $category->get_all();
        if ($categories) {
            $data['categories'] = $categories;
        }

        //get all slider items
        $slider = $this->load_model('slider');
        $slider_rows = $slider->get_all();
        if ($slider_rows) {
            foreach ($slider_rows as $key => $row) {
                $slider_rows[$key]->image = $image_class->get_thumb_post($slider_rows[$key]->image, 484, 441);
            }

            $data['slider_rows'] = $slider_rows;
        }


        //get posts for bottom slider 1
        $slider_rows1 = $DB->read("SELECT * FROM products WHERE rand() LIMIT 3");
        if ($slider_rows1) {
            foreach ($slider_rows1 as $key => $row) {
                $slider_rows1[$key]->image = $image_class->get_thumb_post($slider_rows1[$key]->image);
            }
        }
        $data['slider_rows1'] = $slider_rows1;

        //get posts for bottom slider 2
        $slider_rows2 = $DB->read("SELECT * FROM products WHERE rand() LIMIT 3");
        if ($slider_rows2) {
            foreach ($slider_rows2 as $key => $row) {
                $slider_rows2[$key]->image = $image_class->get_thumb_post($slider_rows2[$key]->image);
            }
        }
        $data['slider_rows2'] = $slider_rows2;

        //get posts for bottom slider 3
        $slider_rows3 = $DB->read("SELECT * FROM products WHERE rand() LIMIT 3");
        if ($slider_rows3) {
            foreach ($slider_rows3 as $key => $row) {
                $slider_rows3[$key]->image = $image_class->get_thumb_post($slider_rows3[$key]->image);
            }
        }
        $data['slider_rows3'] = $slider_rows3;


        $data['rows'] = $rows;
        $data['show_search'] = $show_search;

        //show($data);
        $this->view("index", $data);
    }
}
