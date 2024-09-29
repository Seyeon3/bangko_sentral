<?php

class Router
{
    private $controller = "";
    private $method = "";
    private $params = [];

    public function __construct()
    {
        $url = $this->splitURL();

        // Check if the controller file exists with "Controller" suffix
        $controllerFile = "../app/controllers/" . ucfirst($url[0]) . "Controller.php";
        if (file_exists($controllerFile)) {
            $this->controller = ucfirst($url[0]) . "Controller"; // Set controller with "Controller" suffix
            unset($url[0]);
            require $controllerFile;

            // Instantiate the controller
            $this->controller = new $this->controller;

            // Check if the method exists in the controller
            if (isset($url[1])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                } else {
                    // Method does not exist, set to invalid_page
                    $this->method = 'invalid_page';
                }
            } else {
                // No method specified, use the default method
                $this->method = 'index';
            }
            $this->run($url);
        } else {
            // Controller file does not exist
            require "../app/views/404.php";
            exit();
        }
    }

    private function defaultPage()
    {
        return isset($_GET['url']) ? $_GET['url'] : "login"; 
    }

    private function splitURL()
    {
        $url = $this->defaultPage();
        return explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));
    }

    private function run($url)
    {
        // Set params as an array of values
        $this->params = array_values($url);
        
        // Call the method with parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
