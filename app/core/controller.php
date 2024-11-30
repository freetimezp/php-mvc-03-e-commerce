<?php

class Controller
{
    public function view($path, $data = [])
    {
        if (file_exists("../app/views/" . $path . ".view.php")) {
            include "../app/views/" . $path . ".view.php";
        }
    }
}
