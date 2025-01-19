<?php

class Message
{
    protected $error = array();

    public function create($DATA)
    {
        $db = Database::newInstance();

        $arr['name'] = ucwords($DATA['name']);
        $arr['email'] = $DATA['email'];
        $arr['subject'] = $DATA['subject'];
        $arr['message'] = $DATA['message'];
        $arr['date'] = date("Y-m-d H:i:s");

        if (!preg_match('/^[a-zA-Z 0-9_-]+/', trim($arr['name']))) {
            $this->error[] = "Please, enter a valid name.";
        }

        if (empty($arr['email']) && filter_var($arr['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error[] = "Please, enter a valid email.";
        }

        if (!preg_match('/^[a-zA-Z ]+/', trim($arr['subject']))) {
            $this->error[] = "Please, enter a valid subject name.";
        }

        if (empty($arr['message'])) {
            $this->error[] = "Please, enter a message.";
        }


        if (count($this->error) == 0) {
            $query = "INSERT INTO contact_us (name, email, subject, message, date) 
                VALUES (:name, :email, :subject, :message, :date)";
            $check = $db->write($query, $arr);

            if ($check) return true;
        }

        return $this->error;
    }


    public function delete($id)
    {
        $db = Database::newInstance();
        $id = (int)$id;
        $query = "DELETE FROM contact_us WHERE id = '$id' LIMIT 1";

        $db->write($query);
    }


    public function get_all()
    {
        $arr = array();
        $db = Database::newInstance();
        $query = "SELECT * FROM contact_us ORDER BY id ASC";

        return $db->read($query, $arr);
    }
}
