<?php

class Slider
{
    private $error = "";

    public function create($DATA, $FILES, $image_class = null)
    {
        $db = Database::newInstance();

        $this->error = "";

        $arr['header_text_1'] = ucwords($DATA['header_text_1']);
        $arr['header_text_2'] = ucwords($DATA['header_text_2']);
        $arr['message_text'] = $DATA['message_text'];
        $arr['content_link'] = $DATA['content_link'];


        if (empty($arr['header_text_1']) || !preg_match('/^[a-zA-Z0-9 _-]+/', trim($arr['header_text_1']))) {
            $this->error .= "Please, enter a valid header text 1. <br>";
        }

        if (empty($arr['header_text_2']) || !preg_match('/^[a-zA-Z0-9 _-]+/', trim($arr['header_text_2']))) {
            $this->error .= "Please, enter a valid header text 2. <br>";
        }

        if (empty($arr['message_text'])) {
            $this->error .= "Please, enter a valid message text. <br>";
        }

        if (empty($arr['content_link'])) {
            $this->error .= "Please, enter a valid content link. <br>";
        }


        //no errors
        if ($this->error == "") {
            //check images
            $arr['image'] = "";
            $arr['image2'] = "";

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
                        $this->error .= "Image size must be less then 1 mb. <br>";
                    }
                }
            }


            $query = "INSERT INTO slider_images
                (header_text_1, header_text_2, text, link, image, image2)
                VALUES 
                (:header_text_1, :header_text_2, :message_text, :content_link, :image, :image2)";
            $check = $db->write($query, $arr);

            if ($check) return true;
        }

        return $this->error;
    }
}
