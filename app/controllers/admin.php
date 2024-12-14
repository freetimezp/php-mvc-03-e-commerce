<?php

class Admin extends Controller
{
    public function index()
    {
        $data['page_title'] = "Admin";

        $user = $this->load_model('user');
        $user_data = $user->check_login(true, ['admin']);

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        //show($data);
        $this->view("admin/index", $data);
    }


    public function categories()
    {
        $data['page_title'] = "Admin";

        $user = $this->load_model('user');
        $user_data = $user->check_login(true, ['admin']);

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $db = Database::newInstance();
        $categories = $db->read("SELECT * FROM categories ORDER BY id DESC");

        $category = $this->load_model("category");
        $table_rows = $category->make_table($categories);

        if (!empty($categories)) {
            $data['table_rows'] = $table_rows;
        }

        //show($data);
        $this->view("admin/categories", $data);
    }
}
