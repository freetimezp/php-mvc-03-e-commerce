<?php

class Country
{
    public function get_countries()
    {
        $db = Database::newInstance();

        $query = "SELECT * FROM countries ORDER BY id DESC";
        $data = $db->read($query);

        return $data;
    }


    public function get_states($id)
    {
        $arr['id'] = (int)$id;
        $db = Database::newInstance();

        $query = "SELECT * FROM states WHERE parent = :id ORDER BY id ASC";
        $data = $db->read($query, $arr);

        return $data;
    }
}
