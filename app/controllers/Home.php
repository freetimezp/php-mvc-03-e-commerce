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


        //get posts for bottom slider 1, 2, 3
        $carousel_pages_count = 3;
        $data['slider_bottom_rows'] = array();
        for ($i = 0; $i < $carousel_pages_count; $i++) {
            # code...
            $slider_rows[$i] = $DB->read("SELECT * FROM products WHERE rand() LIMIT 3");
            if ($slider_rows[$i]) {
                foreach ($slider_rows[$i] as $key => $row) {
                    $slider_rows[$i][$key]->image = $image_class->get_thumb_post($slider_rows[$i][$key]->image);
                }
            }
            $data['slider_bottom_rows'][] = $slider_rows[$i];
        }






        $data['rows'] = $rows;
        $data['show_search'] = $show_search;

        //show($data);
        $this->view("index", $data);
    }
}
