<?php

class Admin extends Controller
{
    public function index()
    {
        $data['page_title'] = "Admin";
        $data['current_page'] =  "dashboard";


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
        $data['current_page'] =  "categories";

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
        $data['current_page'] =  "products";

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
        $data['current_page'] =  "orders";

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
        $data['current_page'] =  "users";

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


    public function settings($type = '')
    {
        $data = false;
        $data['page_title'] =  $type;
        $data['current_page'] =  "settings";

        $user = $this->load_model('user');
        $Settings = new Settings();

        $user_data = $user->check_login(true, ['admin']);

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        if ($type == 'socials') {
            if (count($_POST) > 0) {
                $errors = $Settings->save_settings($_POST);

                header("Location: " . ROOT . "admin/settings/socials");
                die;
            }

            $data['settings'] = $Settings->get_all_settings();
        } else if ($type == 'slider_images') {
            $data['action'] = "show";
            $data['id'] = null;

            if (isset($_GET['action']) && $_GET['action'] == 'add') {
                $data['action'] = 'add';

                //new row was posted
                if (count($_POST) > 0) {
                    //show($_POST);
                    //show($_FILES);

                    $Slider = $this->load_model('slider');
                    $Image = $this->load_model('image');

                    $data['errors'] = $Slider->create($_POST, $_FILES, $Image);
                    $data['POST'] = $_POST;

                    header("Location: " . ROOT . "admin/settings/slider_images");
                    die;
                }
            } else if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                $data['action'] = 'edit';

                if (isset($_GET['id'])) {
                    $data['id'] = $_GET['id'];
                }
            } else if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                $data['action'] = 'delete';
            } else if (isset($_GET['action']) && $_GET['action'] == 'delete_comfirmed') {
                $data['action'] = 'delete';
            }
        }

        $this->view("admin/settings", $data);
    }
}
