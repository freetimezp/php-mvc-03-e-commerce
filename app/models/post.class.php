<?php

class Post
{
    public function create($DATA, $FILES, $image_class = null)
    {
        $db = Database::newInstance();

        $_SESSION['error'] = "";

        $arr['url_address'] = str_to_url($DATA['title']);
        $arr['title'] = ucwords($DATA['title']);
        $arr['post'] = $DATA['post'];
        $arr['date'] = date("Y-m-d H:i:s");
        $arr['user_url'] = $_SESSION['user_url'];

        if (!preg_match('/^[a-zA-Z0-9 ,._-]+/', trim($arr['title']))) {
            $_SESSION['error'] .= "Please, enter a valid title. <br>";
        }

        if (empty($DATA['post'])) {
            $_SESSION['error'] .= "Please, enter a valid post text. <br>";
        }


        //make sure url_address is unique
        $url_address_arr = [];
        $url_address_arr['url_address'] = $arr['url_address'];
        $query = "SELECT * FROM blogs WHERE url_address = :url_address LIMIT 1";
        $check = $db->read($query, $url_address_arr);
        if ($check) {
            $arr['url_address'] .= "-" . rand(0, 99999); //add random number if url_address exist in database
        };

        //check images
        $arr['image'] = "";

        $allowed[] = "image/jpeg";
        $allowed[] = "image/png";
        $allowed[] = "image/gif";

        $folder = 'uploads/';
        $size = 1 * 1024 * 1024; //1 mb size

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        foreach ($FILES as $key => $img_row) {
            if ($img_row['error'] == 0 && in_array($img_row['type'], $allowed)) {
                if ($img_row['size'] < $size) {
                    $destination = $folder . $image_class->generate_filename(60) . ".jpg";
                    move_uploaded_file($img_row['tmp_name'], $destination);
                    $arr[$key] = $destination;

                    $image_class->resize_image($destination, $destination, 1500, 1500);
                } else {
                    $_SESSION['error'] .= "Image size must be less then 1 mb. <br>";
                }
            }
        }


        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "INSERT INTO blogs 
                (title, user_url, post, image, date, url_address)
                VALUES 
                (:title, :user_url, :post, :image, :date, :url_address)";
            $check = $db->write($query, $arr);

            if ($check) return true;
        }

        return false;
    }


    public function edit($DATA, $FILES, $image_class = null)
    {
        $db = Database::newInstance();

        $_SESSION['error'] = "";

        $arr['title'] = ucwords($DATA['title']);
        $arr['post'] = $DATA['post'];
        $arr['url_address'] = $DATA['url_address'];

        if (!preg_match('/^[a-zA-Z0-9 ,._-]+/', trim($arr['title']))) {
            $_SESSION['error'] .= "Please, enter a valid title. <br>";
        }

        if (empty($DATA['post'])) {
            $_SESSION['error'] .= "Please, enter a valid post text. <br>";
        }

        //check images
        $arr2['image'] = "";

        $allowed[] = "image/jpeg";
        $allowed[] = "image/png";
        $allowed[] = "image/gif";

        $folder = 'uploads/';
        $size = 1 * 1024 * 1024; //1 mb size

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        foreach ($FILES as $key => $img_row) {
            if ($img_row['error'] == 0 && in_array($img_row['type'], $allowed)) {
                if ($img_row['size'] < $size) {
                    $destination = $folder . $image_class->generate_filename(60) . ".jpg";
                    move_uploaded_file($img_row['tmp_name'], $destination);
                    $arr2[$key] = $destination;

                    $image_class->resize_image($destination, $destination, 1500, 1500);
                } else {
                    $_SESSION['error'] .= "Image size must be less then 1 mb. <br>";
                }
            }
        }


        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            if ($arr2['image'] == "") {
                $query = "UPDATE blogs 
                SET title = :title, post = :post
                WHERE url_address = :url_address LIMIT 1";
            } else {
                $arr['image'] = $arr2['image'];
                $query = "UPDATE blogs 
                SET title = :title, post = :post, image = :image 
                WHERE url_address = :url_address LIMIT 1";
            }
            $check = $db->write($query, $arr);

            if ($check) return true;
        }

        return false;
    }

    public function delete($url_address)
    {
        $db = Database::newInstance();
        $arr['url_address'] = $url_address;

        $query = "DELETE FROM blogs WHERE url_address = :url_address LIMIT 1";

        $db->write($query, $arr);
    }

    public function get_all()
    {
        $arr = array();
        $limit = 2;
        $offset = Page::get_offset($limit);
        $db = Database::newInstance();

        $query = "SELECT * FROM blogs ORDER BY id ASC LIMIT $limit OFFSET $offset";

        return $db->read($query, $arr);
    }

    public function get_one($url_address)
    {
        $db = Database::newInstance();
        $arr['url_address'] = $url_address;

        $data = $db->read("SELECT * FROM blogs WHERE url_address = :url_address LIMIT 1", $arr);

        return $data[0];
    }
}
