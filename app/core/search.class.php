<?php

class Search
{
    public static function get_categories($name = '')
    {
        $DB = Database::newInstance();
        $query = "SELECT id, category FROM categories WHERE disabled = 0 ORDER BY views DESC";

        $data = $DB->read($query);

        if (is_array($data)) {
            foreach ($data as $row) {
                echo "<option value='$row->id' " . self::get_sticky('select', $name, $row->id) . ">$row->category</option>";
            }
        }
    }

    public static function get_brands($name = '')
    {
        $DB = Database::newInstance();
        $query = "SELECT id, brand FROM brands WHERE disabled = 0 ORDER BY views DESC";

        $data = $DB->read($query);

        if (is_array($data)) {
            foreach ($data as $key => $row) {
                echo "<label for='brand-" . $row->id . "'>
                        <input id='brand-$row->id' value='$row->id' type='checkbox' class='form-checkbox-input'
                            name='brand-$key' "
                    . self::get_sticky('checkbox', 'brand-' . $key, $row->id) . ">" . $row->brand  . "
                    </label>";
            }
        }
    }

    public static function get_years($name = '')
    {
        $DB = Database::newInstance();
        $query = "SELECT id, date FROM products GROUP BY year(date)";

        $data = $DB->read($query);

        if (is_array($data)) {
            foreach ($data as $row) {
                $year = date("Y", strtotime($row->date));
                echo "<option " . self::get_sticky('select', $name, $year) .  ">" . $year . "</option>";
            }
        }
    }

    public static function get_sticky($type, $name, $value = '')
    {
        switch ($type) {
            case 'textbox':
                echo isset($_GET[$name]) ? $_GET[$name] : '';
                break;

            case 'number':
                echo isset($_GET[$name]) ? $_GET[$name] : 0;
                break;

            case 'select':
                return (isset($_GET[$name]) && $value == $_GET[$name]) ? 'selected' : '';
                break;

            case 'checkbox':
                return (isset($_GET[$name]) && $value == $_GET[$name]) ? 'checked' : '';
                break;

            default:
                break;
        }
    }
}
