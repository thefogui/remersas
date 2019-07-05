<?php

class Router {
    // Routers array where we store the various routers defined 
    private $routers;
    public $controller;
    public $method;
    public $param;

    public $uri;

    public function __construct() {
        $this->setUri();
        $this->setController();
        $this->setMethod();
        $this->setParam();
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
    function add_route($route, callable $closure) {
        $this->routes[$route] = $closure;
    }
 
    /* Execute the specified route defined */
    function execute($path) {
        
        /* Check if the given route is defined,
         * or execute the default '/' home route.
         */
        if(array_key_exists($path, $this->routes)) {
            $this->routes[$path]();
        } else {
            $this->routes['/']();
        }
    }   
}