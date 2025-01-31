<?php

class Search
{
    public static function get_categories()
    {
        $DB = Database::newInstance();
        $query = "SELECT id, category FROM categories WHERE disabled = 0 ORDER BY views DESC";

        $data = $DB->read($query);

        if (is_array($data)) {
            foreach ($data as $row) {
                echo "<option id='$row->id'>$row->category</option>";
            }
        }
    }

    public static function get_brands()
    {
        $DB = Database::newInstance();
        $query = "SELECT id, brand FROM brands WHERE disabled = 0 ORDER BY views DESC";

        $data = $DB->read($query);

        if (is_array($data)) {
            foreach ($data as $key => $row) {
                echo "<label for='brand-" . $row->id . "'>
                        <input id='brand-$row->id' value='$row->id' type='checkbox' class='form-checkbox-input'
                            name='brand-$key'>" . $row->brand  . "
                    </label>";
            }
        }
    }

    public static function get_years()
    {
        $DB = Database::newInstance();
        $query = "SELECT id, date FROM products GROUP BY year(date)";

        $data = $DB->read($query);

        if (is_array($data)) {
            foreach ($data as $row) {
                echo "<option>" . date("Y", strtotime($row->date)) . "</option>";
            }
        }
    }
}
