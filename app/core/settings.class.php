<?php

class Settings
{
    private $errors = array();
    protected $table = 'settings';
    protected static $SETTINGS = null;

    public function get_all_settings()
    {
        $data = array();
        $db = Database::newInstance();
        $query = "SELECT * FROM settings";

        return $db->read($query, $data);
    }

    //run this magic function if method not exist
    public static function  __callStatic($name, $arguments)
    {
        if (self::$SETTINGS) {
            $settings = self::$SETTINGS;
        } else {
            $settings = self::get_all_settings_as_object();
        }

        if (isset($settings->$name)) {
            return $settings->$name;
        }

        return "";
    }

    //use static for get constant data? we can display them on each page
    public static function get_all_settings_as_object()
    {
        $db = Database::newInstance();
        $query = "SELECT * FROM settings";

        $data = $db->read($query);

        $settings = (object)[];
        if (is_array($data)) {
            foreach ($data as $row) {
                $setting_name = $row->setting;
                $settings->$setting_name = $row->value;
            }
        }

        self::$SETTINGS = $settings;
        return $settings;
    }


    public function save_settings($POST)
    {
        $arr = array();
        $db = Database::newInstance();

        foreach ($POST as $key => $value) {
            $arr['setting'] = $key;

            if (strstr($key, "_link")) {
                show(123);
                if (trim($value) != "" && !strstr($value, "https://")) {
                    $value = "https://" . $value;
                }
                $arr['value'] = $value;
            } else {
                $arr['value'] = $value;
            }

            $query = "UPDATE settings SET value = :value WHERE setting = :setting LIMIT 1";

            $db->write($query, $arr);

            $this->errors[] = "An error in save settings";
        }

        return $this->errors;
    }
}
