<?php

class Product_details extends Controller
{
    public function index($slag)
    {
        $slag = esc($slag);
        $data['page_title'] = "Product details";

        $user = $this->load_model('user');
        $user_data = $user->check_login();

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $DB = Database::newInstance();
        $row = $DB->read("SELECT * FROM products WHERE slag = :slag LIMIT 1", ['slag' => $slag]);
        if (isset($row[0])) {
            $data['row'] = $row[0];
        }

        //show($data);
        if (isset($data['row'])) {
            $this->view("product-details", $data);
        }

        $this->view("404", $data);
    }
}
