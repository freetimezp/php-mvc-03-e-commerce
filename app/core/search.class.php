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
                echo "<label for='brand-" . $row->id . "' style='margin-right: 10px;' >
                        <input id='brand-$row->id' value='$row->id' type='checkbox' class='form-checkbox-input'
                            name='brand-$key' style='margin-right: 5px;' "
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

    public static function get_sticky($type, $name, $value = '', $default = null)
    {
        switch ($type) {
            case 'textbox':
                echo isset($_GET[$name]) ? $_GET[$name] : '';
                break;

            case 'number':
                $def = 0;
                if ($default) {
                    $def = $default;
                }
                echo isset($_GET[$name]) ? $_GET[$name] : $def;
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


    public static function make_query($GET, $limit = 10, $offset = 0)
    {
        $params = array();
        $brands = array();

        if (isset($GET['description']) && trim($GET['description']) != "") {
            $params['description'] = $GET['description'];
        }

        if (isset($GET['category']) && trim($GET['category']) != "--Choose--") {
            $params['category'] = $GET['category'];
        }

        if (isset($GET['year']) && trim($GET['year']) != "--Choose--") {
            $params['year'] = $GET['year'];
        }

        if (
            isset($GET['min-price'])
            && trim($GET['max-price']) != "0"
            && trim($GET['min-price']) != ""
            && trim($GET['max-price']) != ""
        ) {
            $params['min-price'] = (float)$GET['min-price'];
            $params['max-price'] = (float)$GET['max-price'];
        }

        if (
            isset($GET['min-qty'])
            && trim($GET['max-qty']) != "0"
            && trim($GET['min-qty']) != ""
            && trim($GET['max-qty']) != ""
        ) {
            $params['min-qty'] = (int)$GET['min-qty'];
            $params['max-qty'] = (int)$GET['max-qty'];
        }


        foreach ($GET as $key => $value) {
            if (strstr($key, "brand-")) {
                $brands[] = $value;
            }
        }
        if (count($brands) > 0) {
            $params['brands'] = implode("','", $brands);
        }


        $query = "SELECT prod.*, brands.brand as brand_name, cat.category as category_name  
                FROM products as prod 
                JOIN brands ON brands.id = prod.brand
                JOIN categories as cat ON cat.id = prod.category ";



        if (count($params) > 0) {
            $query .= " WHERE ";
        }

        //search by description
        if (isset($params['description'])) {
            $description = $params['description'];
            $query .= "prod.description LIKE '%$description%' AND ";
        }

        //search by category
        if (isset($params['category'])) {
            $category = $params['category'];
            $query .= "cat.id LIKE '$category' AND ";
        }

        //search by min, max price
        if (isset($params['min-price'])) {
            $min_price = $params['min-price'];
            $max_price = $params['max-price'];
            $query .= "(prod.price BETWEEN '$min_price' AND '$max_price') AND ";
        }

        //search by min, max quantity
        if (isset($params['min-qty'])) {
            $min_qty = $params['min-qty'];
            $max_qty = $params['max-qty'];
            $query .= "(prod.quantity BETWEEN '$min_qty' AND '$max_qty') AND ";
        }

        //search by year
        if (isset($params['year'])) {
            $year = $params['year'];
            $query .= "YEAR(prod.date) = '$year' AND ";
        }

        //search by brands
        if (isset($params['brands'])) {
            $query .= "brands.id IN ('" . $params['brands'] . "') AND ";
        }


        $query = trim($query);
        $query = trim($query, "AND");
        $query .= " ORDER BY prod.id DESC LIMIT $limit OFFSET $offset";

        //show($query);
        return $query;
    }
}
