<?php

class App
{
    private $controller = "home";
    private $method = "index";
    private $params;

    public function __construct()
    {
        $url = $this->parseURL();
        //show($url);

        $url[0] = str_replace("-", "_", $url[0]);
        //check if file controller exist
        if (file_exists("../app/controllers/" . strtolower($url[0]) . ".php")) {
            $this->controller = strtolower($url[0]);
            unset($url[0]);
        }

        //require controller
        require "../app/controllers/" . $this->controller . ".php";
        $this->controller = new $this->controller;

        //check if method exist
        if (isset($url[1])) {
            $url[1] = strtolower($url[1]);

            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = count($url) > 0 ? array_values($url) : ['home'];
        //show($this->params);

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseURL()
    {
        //grub url from browser
        $url = isset($_GET['url']) ? $_GET['url'] : "home";

        //sinitize & trim URL
        return explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));
    }
}
