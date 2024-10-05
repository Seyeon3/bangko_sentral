<?php

class Router
{
    private $controller = "";
    private $method = "";
    private $params = [];

    public function __construct()
    {
        $url = $this->splitURL();

        // Check if the controller file exists with the "Controller" suffix
        if (!empty($url[0])) {
            $controllerFile = "../app/controllers/" . ucfirst($url[0]) . "Controller.php";

            if (file_exists($controllerFile)) {
                $this->controller = ucfirst($url[0]) . "Controller"; // Set the controller name
                unset($url[0]);
                require_once $controllerFile;

                // Instantiate the controller
                $this->controller = new $this->controller;
            } else {
                // If controller file doesn't exist, show 404
                $this->invalidPage();
                return;
            }
        } else {
            // Default controller when no controller is in the URL
            $this->controller = "LoginController";
            require_once "../app/controllers/LoginController.php";
            $this->controller = new $this->controller;
        }

        // Check for the method if provided, otherwise use default 'index'
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                // If method doesn't exist, show invalid page
                $this->method = 'invalid_page';
            }
        } else {
            // Default method 'index'
            $this->method = 'index';
        }

        // Get remaining URL params (if any)
        $this->params = $url ? array_values($url) : [];

        // Call the method of the controller, passing params
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Default page loader when no URL is provided
    private function defaultPage()
    {
        return isset($_GET['url']) ? $_GET['url'] : "login";
    }

    // Splits the URL into controller, method, and parameters
    private function splitURL()
    {
        // Sanitize and return the URL as an array
        $url = $this->defaultPage();
        return explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));
    }

    // Handle invalid pages (404 not found)
    private function invalidPage()
    {
        // Load 404 view if page or controller not found
        require_once "../app/views/404.php";
        exit();
    }
}
?>
