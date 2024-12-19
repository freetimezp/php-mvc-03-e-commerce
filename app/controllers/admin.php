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


    public function products()
    {
        $data['page_title'] = "Admin";

        $user = $this->load_model('user');
        $user_data = $user->check_login(true, ['admin']);

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $db = Database::newInstance();
        $products = $db->read("SELECT * FROM products ORDER BY id DESC");
        $categories = $db->read("SELECT * FROM categories WHERE disabled = 0 ORDER BY id DESC");


        $product = $this->load_model("product");
        $category = $this->load_model("category");
        $table_rows = $product->make_table($products, $category);

        $data['table_rows'] = $table_rows;
        $data['categories'] = $categories;

        //show($data);
        $this->view("admin/products", $data);
    }
}
