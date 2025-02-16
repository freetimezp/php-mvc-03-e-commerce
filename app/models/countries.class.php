<?php


class Countries
{
    public function get_countries()
    {
        $db = Database::newInstance();

        $query = "SELECT * FROM countries ORDER BY id DESC";
        $data = $db->read($query);

        return $data;
    }


    public function get_states($country)
    {
        $arr['country'] = addslashes($country);
        $db = Database::newInstance();
        $data = false;

        $query = "SELECT * FROM countries WHERE country = :country LIMIT 1";
        $check = $db->read($query, $arr);

        if (is_array($check)) {
            $arr = false;
            $arr['id'] = $check[0]->id;
            $query = "SELECT * FROM states WHERE parent = :id ORDER BY id ASC";
            $data = $db->read($query, $arr);
        }

        return $data;
    }


    public function get_country($id)
    {
        $id = (int)$id;
        $db = Database::newInstance();

        $query = "SELECT * FROM countries WHERE id = '$id' LIMIT 1";
        $data = $db->read($query);

        return is_array($data) ? $data[0] : false;
    }


    public function get_state($id)
    {
        $arr['id'] = (int)$id;
        $db = Database::newInstance();

        $query = "SELECT * FROM states WHERE id = :id LIMIT 1";
        $data = $db->read($query, $arr);

        return is_array($data) ? $data[0] : false;
    }
}
