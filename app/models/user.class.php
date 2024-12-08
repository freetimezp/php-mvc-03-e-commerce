<?php

class User
{
    private $error = "";

    protected $table = 'users';

    public function signup($POST)
    {
        $data = [];
        $db = Database::getInstance();

        $data['name'] = trim($_POST['name']);
        $data['email'] = trim($_POST['email']);
        $data['password'] = trim($_POST['password']);
        $password2 = trim($_POST['password2']);

        //validate name
        if (empty($data['name']) || !preg_match("/^[a-zA-Z0-9_-]+$/", $data['name'])) {
            $this->error .= "Please enter a valid name. Use only letters, numbers, -, _. <br>";
        }

        //validate email
        if (empty($data['email']) || !preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z]+.[a-zA-Z]+$/", $data['email'])) {
            $this->error .= "Please enter a valid email. Use only letters, numbers, -, _. <br>";
        }

        //validate passwords
        if ($data['password'] != $password2) {
            $this->error .= "Passwords do not match. <br>";
        }
        if (strlen($data['password']) < 8) {
            $this->error .= "Password must be at least 8 characters long. <br>";
        }


        //check if email already exist
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $check = $db->read($sql, ['email' => $data['email']]);
        if (is_array($check)) {
            $this->error .= "This email already in use. Try another, please. <br>";
        }


        //check unique url string id
        $data['url_address'] = $this->random_string(60);
        $sql2 = "SELECT * FROM users WHERE url_address = :url_address LIMIT 1";
        $check2 = $db->read($sql2, ['url_address' => $data['url_address']]);
        if (is_array($check2)) {
            $data['url_address'] = $this->random_string(60);
        }

        if ($this->error == "") {
            //save
            $data['rank'] = "customer";
            $data['date'] = date("Y-m-d H:i:s");
            $data['password'] = hash("sha1", $data['password']);

            $query = "INSERT INTO users (url_address, name, email, password, rank, date) 
                VALUES (:url_address, :name, :email, :password, :rank, :date)";

            $result = $db->write($query, $data);

            if ($result) {
                header("Location: " . ROOT . "login");
                die;
            }
        }

        $_SESSION['error'] = $this->error;
    }

    public function login($POST)
    {
        $data = [];
        $db = Database::getInstance();

        $data['email'] = trim($_POST['email']);
        $data['password'] = trim($_POST['password']);

        //validate email
        if (empty($data['email']) || !preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z]+.[a-zA-Z]+$/", $data['email'])) {
            $this->error .= "Please enter a valid email. Use only letters, numbers, -, _. <br>";
        }

        //validate passwords
        if (strlen($data['password']) < 8) {
            $this->error .= "Password must be at least 8 characters long. <br>";
        }

        if ($this->error == "") {
            //get user from db
            $data['password'] = hash("sha1", $data['password']);

            $query = "SELECT * FROM users WHERE email = :email && password = :password LIMIT 1";
            $result = $db->read($query, $data);
            if (is_array($result)) {
                $_SESSION['user_url'] = $result[0]->url_address;

                header("Location: " . ROOT . "home");
                die;
            }

            //if email not found or password not match
            $this->error .= "User not found or password is incorrect. <br>";
        }

        $_SESSION['error'] = $this->error;
    }

    public function get_user($url) {}

    private function random_string($length)
    {
        $array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $text = '';
        for ($x = 0; $x < $length; $x++) {
            $random = rand(0, 61);
            $text .= $array[$random];
        }
        return $text;
    }


    public function check_login($redirect = false, $allowed = [])
    {
        $db = Database::getInstance();
        if (count($allowed) > 0) {
            //show("here admin");

            $arr['url'] = isset($_SESSION['user_url']) ? $_SESSION['user_url'] : "";
            $query = "SELECT * FROM users WHERE url_address = :url LIMIT 1";
            $result = $db->read($query, $arr);

            if (is_array($result)) {
                $result = $result[0];
                //show($result->rank);

                if (in_array($result->rank, $allowed)) {
                    return $result;
                }
            }

            header("Location: " . ROOT . "login");
            die;
        } else {
            //show("here customer or not admin");

            if (isset($_SESSION['user_url'])) {
                $arr = false;
                $arr['url'] = $_SESSION['user_url'];

                $query = "SELECT * FROM users WHERE url_address = :url LIMIT 1";
                $result = $db->read($query, $arr);

                if (is_array($result)) {
                    return $result[0];
                }
            }

            if ($redirect) {
                header("Location: " . ROOT . "login");
                die;
            }
        }

        return false;
    }


    public function logout()
    {
        if (isset($_SESSION['user_url'])) {
            unset($_SESSION['user_url']);
        }

        header("Location: " . ROOT . "home");
        die;
    }


    //create table users
    public function create_table()
    {
        $query = "create table if not exists users(
			id int primary key auto_increment,
			url_address varchar(60) not null,
			name varchar(20) not null,
			email varchar(100) not null,
			password varchar(64) not null,
			date datetime not null,
			rank varchar(10) not null			
		)";
        $db = new Database();
        //show($db);
        $db->query($query);
    }

    //create table categories
    public function create_table_categories()
    {
        $query = "create table if not exists categories(
			id int primary key auto_increment,
			category varchar(30) not null		
		)";
        $db = new Database();
        //show($db);
        $db->query($query);
    }

    //create table products
    public function create_table_products()
    {
        $query = "create table if not exists products(
			id int primary key auto_increment,
			user_url varchar(60) not null,
			description varchar(250) not null,
			category int not null,
			price double not null,
			quantity int not null,
			image varchar(500) null,
			image2 varchar(500) null,
			image3 varchar(500) null,
			image4 varchar(500) null,
			date datetime not null,
			slag varchar(100) not null		
		)";
        $db = new Database();
        //show($db);
        $db->query($query);
    }
}
