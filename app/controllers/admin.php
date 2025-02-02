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
        $category = $this->load_model("category");
        $user_data = $user->check_login(true, ['admin']);

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $db = Database::newInstance();
        $categories = $category->get_all();
        $categories_enabled = $db->read("SELECT * FROM categories WHERE disabled = 0 ORDER BY id DESC");

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
        $search = false;
        if (isset($_GET['search'])) {
            //show($_GET);
            $search = true;
        }

        $data['page_title'] = "Admin";
        $data['current_page'] =  "products";

        $user = $this->load_model('user');
        $product = $this->load_model("product");
        $category = $this->load_model("category");

        $user_data = $user->check_login(true, ['admin']);

        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        $db = Database::newInstance();

        if ($search) {
            $limit = 5;
            $offset = Page::get_offset($limit);

            $params = array();
            $brands = array();

            if (isset($_GET['description']) && trim($_GET['description']) != "") {
                $params['description'] = $_GET['description'];
            }

            if (isset($_GET['category']) && trim($_GET['category']) != "--Choose--") {
                $params['category'] = $_GET['category'];
            }

            if (isset($_GET['year']) && trim($_GET['year']) != "--Choose--") {
                $params['year'] = $_GET['year'];
            }

            if (
                isset($_GET['min-price'])
                && trim($_GET['max-price']) != "0"
                && trim($_GET['min-price']) != ""
                && trim($_GET['max-price']) != ""
            ) {
                $params['min-price'] = (float)$_GET['min-price'];
                $params['max-price'] = (float)$_GET['max-price'];
            }

            if (
                isset($_GET['min-qty'])
                && trim($_GET['max-qty']) != "0"
                && trim($_GET['min-qty']) != ""
                && trim($_GET['max-qty']) != ""
            ) {
                $params['min-qty'] = (int)$_GET['min-qty'];
                $params['max-qty'] = (int)$_GET['max-qty'];
            }


            foreach ($_GET as $key => $value) {
                if (strstr($key, "brand-")) {
                    $brands[] = $value;
                }
            }
            if (count($brands) > 0) {
                $params['brands'] = implode("','", $brands);
            }


            $query = "SELECT prod.*, brands.brand as brand_name, cat.category as category_name  
                FROM products as prod 
                JOIN brands ON brands.id = prod.brand
                JOIN categories as cat ON cat.id = prod.category ";



            if (count($params) > 0) {
                $query .= " WHERE ";
            }

            //search by description
            if (isset($params['description'])) {
                $description = $params['description'];
                $query .= "prod.description LIKE '%$description%' AND ";
            }

            //search by category
            if (isset($params['category'])) {
                $category = $params['category'];
                $query .= "cat.id LIKE '$category' AND ";
            }

            //search by min, max price
            if (isset($params['min-price'])) {
                $min_price = $params['min-price'];
                $max_price = $params['max-price'];
                $query .= "(prod.price BETWEEN '$min_price' AND '$max_price') AND ";
            }

            //search by min, max quantity
            if (isset($params['min-qty'])) {
                $min_qty = $params['min-qty'];
                $max_qty = $params['max-qty'];
                $query .= "(prod.quantity BETWEEN '$min_qty' AND '$max_qty') AND ";
            }

            //search by year
            if (isset($params['year'])) {
                $year = $params['year'];
                $query .= "YEAR(prod.date) = '$year' AND ";
            }

            //search by brands
            if (isset($params['brands'])) {
                $query .= "brands.id IN ('" . $params['brands'] . "') AND ";
            }


            $query = trim($query);
            $query = trim($query, "AND");
            $query .= " ORDER BY prod.id DESC LIMIT $limit OFFSET $offset";

            //show($query);
            $products = $db->read($query);
        } else {
            $limit = 5;
            $offset = Page::get_offset($limit);

            $query = "SELECT prod.*, brands.brand as brand_name, cat.category as category_name 
                FROM products as prod 
                JOIN brands ON prod.brand = brands.id 
                JOIN categories as cat ON cat.id = prod.category
                ORDER BY prod.id DESC 
                LIMIT $limit OFFSET $offset";

            $products = $db->read($query);
        }

        $categories = $db->read("SELECT * FROM categories WHERE disabled = 0 ORDER BY id DESC");
        $brands = $db->read("SELECT * FROM brands WHERE disabled = 0 ORDER BY id DESC");


        $table_rows = $product->make_table($products, $category);

        $data['table_rows'] = $table_rows;
        $data['categories'] = $categories;
        $data['brands'] = $brands;

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


    public function messages($type = '')
    {
        $data = false;
        $data['page_title'] =  "Contact Messages";
        $data['current_page'] =  "messages";

        $User = $this->load_model('user');
        $Message = $this->load_model('message');

        $mode = "read";

        if (isset($_GET['delete'])) {
            $mode = "delete";
        } else if (isset($_GET['delete_confirmed'])) {
            $mode = "delete_confirmed";
            $id = $_GET['delete_confirmed'];
            $messages = $Message->delete($id);
        }

        $user_data = $User->check_login(true, ['admin']);
        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        if ($mode == 'delete') {
            $id = $_GET['delete'];

            $messages = $Message->get_one($id);
            $data['messages'] = $messages;
        } else {
            $messages = $Message->get_all();

            if (is_array($messages)) {
                $data['messages'] = $messages;
            }
        }

        $data['mode'] = $mode;

        $this->view("admin/messages", $data);
    }


    public function blogs($type = '')
    {
        $data = false;
        $data['page_title'] =  "Blog Posts";
        $data['current_page'] =  "blogs";

        $User = $this->load_model('user');
        $Post = $this->load_model('post');
        $image_class = $this->load_model('image');

        $mode = "read";

        $user_data = $User->check_login(true, ['admin']);
        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }

        if (isset($_GET['add_new'])) {
            $mode = "add_new";
        }

        if (isset($_GET['edit'])) {
            $mode = "edit";
        }

        //if something was posted
        if (count($_POST) > 0) {
            if ($mode == 'edit') {
                $Post->edit($_POST, $_FILES, $image_class);
            } else {
                $Post->create($_POST, $_FILES, $image_class);
            }

            if (isset($_SESSION['error']) && $_SESSION['error'] != "") {
                $data['errors'] = $_SESSION['error'];
                $data['POST'] = $_POST;
            } else {
                redirect("admin/blogs");
            }
        }



        if (isset($_GET['delete'])) {
            $mode = "delete";
        }

        if (isset($_GET['delete_confirmed'])) {
            $mode = "delete_confirmed";
            $id = $_GET['delete_confirmed'];
            $posts = $Post->delete($id);
        }


        if ($mode == 'edit') {
            $id = $_GET['edit'];

            $post = $Post->get_one($id);
            $data['blog'] = $post;
        }
        if ($mode == 'delete') {
            $id = $_GET['delete'];

            $post = $Post->get_one($id);

            if ($post) {
                if (!empty($post->image)) {
                    $post->image = $image_class->get_thumb_post($post->image);
                }

                $post->author_data = $User->get_user($post->user_url);
            }

            $data['blog'] = $post;
        } else {
            $posts = $Post->get_all();

            if (is_array($posts)) {

                foreach ($posts as $key => $row) {
                    if (!empty($posts[$key]->image)) {
                        $posts[$key]->image = $image_class->get_thumb_post($posts[$key]->image);
                    }

                    $posts[$key]->author_data = $User->get_user($row->user_url);
                }

                $data['blogs'] = $posts;
            }
        }

        $data['mode'] = $mode;

        $this->view("admin/blogs", $data);
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

            $Slider = $this->load_model('slider');
            $Image = $this->load_model('image');

            //read all slider images
            $data['rows'] = $Slider->get_all();
            //show($data);

            if (isset($_GET['action']) && $_GET['action'] == 'add') {
                $data['action'] = 'add';

                //new row was posted
                if (count($_POST) > 0) {
                    //show($_POST);
                    //show($_FILES);

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
