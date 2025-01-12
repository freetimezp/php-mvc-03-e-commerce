<?php

class Settings
{
    private $errors = array();

    protected $table = 'settings';

    public function get_all()
    {
        $data = array();
        $db = Database::newInstance();
        $query = "SELECT * FROM settings";

        return $db->read($query, $data);
    }


    public function save($POST)
    {
        $arr = array();
        $data = array();
        $db = Database::newInstance();

        foreach ($POST as $key => $value) {
            $arr['setting'] = $key;
            $arr['value'] = $value;
            $query = "UPDATE settings SET value = :value WHERE setting = :setting LIMIT 1";

            $db->write($query, $arr);

            $this->errors[] = "An error in save settings";
        }

        return $this->errors;
    }
}
