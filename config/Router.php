<?php

class Router {
    // Routers array where we store the various routers defined 
    private $routers;
    public $controller;
    public $method;
    public $param;
    private static $instance;

    public $uri;

    private function __construct() {
        $this->routers = Array();
        $this->setUri();
        $this->setController();
        $this->setMethod();
        $this->setParam();
    }

    public static function getInstance() {
        if (!Router::$instance instanceof self) {
            Router::$instance = new self();
        }
        return Router::$instance;
    }


    public function setUri() {
        $this->uri = explode('/', $_SERVER['REQUEST_URI']);
    }

    public function setcontroller() {
        $this->controller = $this->uri[2] === '' ? 'Home' : $this->uri[2];
    }

    public function setMethod() {
        $this->method = !empty($this->uri[3]) ? $this->uri[3] : 'exec';
    }

    public function setParam() {
        $this->param = !empty($this->uri[4]) ? $this->uri[4] : '';
    }

    public function getUri() {
        return $this->uri;
    }

    public function getController() {
        return $this->controller;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getParam() {
        return $this->param;
    }

    /* The methods adds each route defined to the $routes array */
    function add_route($route, $function, $method='GET') {
        array_push($this->routers, Array(
            'expression' => $route,
            'function' => $function,
            'method' => $method
        ));
    }
 
    /* Execute the specified route defined */
    function execute($basepath = '/') {
        
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);//Parse Uri
        
        if (isset($parsed_url['path'])) {
            $path = $parsed_url['path'];
        } else {
            $path = '/';
        }

        // Get current request method
        $method = $_SERVER['REQUEST_METHOD'];

        $pathFound = false;
        $routFound = false;

        $routersSize = count($this->routers);

        $i = 0;

        while ((!$pathFound || !$routFound) && ($i < $routersSize)) {

            //add basepath to the string 
            if ($basepath != '' && $basepath != '/') {
                $this->routers[$i]['expression'] = '('.$basepath.')'.$this->routers[$i]['expression'];
            }

            // Add 'find string start' automatically
            $this->routers[$i]['expression'] = '^'.$this->routers[$i]['expression'];

            // Add 'find string end' automatically
            $this->routers[$i]['expression'] = $this->routers[$i]['expression'].'$';

            if (preg_match('#'.$this->routers[$i]['expression'].'#', $path, $matches)) {
                $pathFound = true;

                //check the method
                if(strtolower($method) == strtolower($this->routers[$i]['method'])){
                    $routFound = true;

                    array_shift($matches);// Always remove first element. This contains the whole string

                    if($basepath != '' && $basepath != '/'){
                        array_shift($matches);// Remove basepath 
                    }
            
                    call_user_func_array($this->routers[$i]['function'], $matches);
                }
            }

            $i += 1;
        }

        // No matching route was found
        if(!$pathFound){
            // But a matching path exists
            if(!$routFound){
                header("HTTP/1.0 405 Method Not Allowed");
            } else {
                header("HTTP/1.0 404 Not Found");
            }
        }
    }   
}