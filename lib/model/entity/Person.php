<?php 

/**
 * Class that represents a person, it cotains the basic information to identify one person
 * @package 
 * @see     
 */
class Person {
    protected $nif;
    protected $name;

    public function __construct() {
        $args = func_get_args();

        if (count(args) > 0) {
            $this->Person(args[0], args[1]);
        }
    }

    public function Person($nif, $name) {
        $this->nif = $nif;
        $this->name = $name;
    }

    public function __toString() {
        
    }
}