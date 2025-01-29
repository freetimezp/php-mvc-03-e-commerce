<?php

class Home extends Controller
{
    public function index()
    {
        //pagination
        $limit = 6;
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
            $rows = $DB->read("SELECT * FROM products WHERE description LIKE :description LIMIT $limit OFFSET $offset", $arr);
        } else {
            $rows = $DB->read("SELECT * FROM products LIMIT $limit OFFSET $offset");
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


        //get products for lower segment 
        $data['segment_data'] = $this->get_segment_data($DB, $data['categories'], $image_class);



        $data['rows'] = $rows;
        $data['show_search'] = $show_search;

        //show($data);
        $this->view("index", $data);
    }

    private function get_segment_data($DB, $categories, $image_class)
    {
        $mycats = array();
        $arr = array();
        $result = array();
        $num = 0;

        foreach ($categories as $cat) {
            $arr['id'] = $cat->id;
            $rows = $DB->read("SELECT * FROM products WHERE category = :id ORDER BY rand() LIMIT 5", $arr);

            if (is_array($rows)) {
                $cat->category = str_replace(" ", "_", $cat->category);
                $cat->category = preg_replace("/\W+/", "", $cat->category); //if not a word than replace

                //crop images
                foreach ($rows as $key => $row) {
                    $rows[$key]->image = $image_class->get_thumb_post($rows[$key]->image, 600, 350);
                }

                $result[$cat->category] = $rows;


                $num++;
                if ($num > 5) break;

                $mycats[] = $cat;
            }
        }

        return $result;
    }
}
