<?php

class View {
    /**
     * Template being rendered.
     */
    protected $template = null;
    protected $vars;

    /**
     * Initialize a new view context.
     */
    public function __construct($template) {
        $this->vars = array();
        $this->template = $template;
    }

    /* __get() and __set() are run when writing data to inaccessible properties.
     * Get template variables
     */
    public function __get($key){
        return $this->vars[$key];
    }

    /*
     * Set template variables
     */
    public function __set($key, $value){
        $this->vars[$key] = $value;
    }

    /*
     * Convert Object To String
     */
    public function __toString(){
        extract($this->vars); // extract our template variables ex: $value
        
        ob_start(); // store as internal buffer

        include (dirname(__FILE__) . $this->template);  // include the template into our file

        return ob_get_clean();
    }
}