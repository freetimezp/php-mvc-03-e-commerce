<?php

class Settings
{
    private $error = "";

    protected $table = 'settings';

    public function get_all()
    {
        $data = array();
        $db = Database::newInstance();
        $query = "SELECT * FROM settings";

        return $db->read($query, $data);
    }
}
