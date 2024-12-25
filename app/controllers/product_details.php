<?php

class Product_details extends Controller
{
    public function index($id)
    {
        $id = (int)$id;
        $data['page_title'] = "Product details";


        $user = $this->load_model('user');
        $user_data = $user->check_login();

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $DB = Database::newInstance();
        $row = $DB->read("SELECT * FROM products WHERE id = :id LIMIT 1", ['id' => $id]);
        if (isset($row[0])) {
            $data['row'] = $row[0];
        }

        //show($data);
        $this->view("product-details", $data);
    }
}
