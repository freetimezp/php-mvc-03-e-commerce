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
        $categories_enabled = $db->read("SELECT * FROM categories WHERE disabled = 0 ORDER BY id DESC");

        $category = $this->load_model("category");
        $table_rows = $category->make_table($categories);

        if (!empty($categories)) {
            $data['table_rows'] = $table_rows;
        }

        if (!empty($categories_enabled)) {
            $data['categories'] = $categories_enabled;
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


    public function orders()
    {
        $data = false;
        $data['page_title'] = "Admin - Orders";

        $user = $this->load_model('user');
        $order = $this->load_model('order');

        $user_data = $user->check_login(true, ['admin']);

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $orders = $order->get_all_orders();

        if (is_array($orders)) {

            foreach ($orders as $key => $row) {
                # code...
                $details = $order->get_order_details($row->id);
                $orders[$key]->grand_total = 0;

                if ($details) {
                    $totals = array_column($details, 'total');
                    $grand_total = array_sum($totals);

                    $orders[$key]->details = $details;
                    $orders[$key]->grand_total = $grand_total;

                    $user_row = $user->get_user($row->user_url);
                    $orders[$key]->user = $user_row;
                }
            }

            //show($orders);
            $data['orders'] = $orders;
        }


        $this->view("admin/orders", $data);
    }


    public function users($type = "customers")
    {
        $data = false;
        $data['page_title'] =  ucfirst($type) . " list";

        $user = $this->load_model('user');
        $order = $this->load_model('order');

        $user_data = $user->check_login(true, ['admin']);

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        if ($type == "admins") {
            $users = $user->get_admins();
        } else {
            $users = $user->get_customers();
        }

        if (is_array($users)) {
            $data['users'] = $users;

            foreach ($users as $key => $row) {
                $orders_num = $order->get_orders_count($row->url_address);
                $users[$key]->orders_count = $orders_num;
            }
        }


        $this->view("admin/users", $data);
    }
}
