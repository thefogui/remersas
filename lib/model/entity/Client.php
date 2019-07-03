<?php 

/**
 * Class that are associated with the client information
 * @package 
 * @see     
 */
class Client extends Person {
    private $email;

    public function __construct() {
        $args = func_get_args();

        if (count(args) > 0) {
            $this->Client(args[0], args[1], args[2]);
        }
    }

    public function Client($nif, $name, $email) {
        parent::__construct($nif, $name);
        $this->email = email;
    }
}