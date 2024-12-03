<?php

class User
{
    private $error = "";

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

    public function login($POST) {}

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
}
