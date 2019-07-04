<?php 

require_once "Person.php";

/**
 * Class that are associated with the client information
 * @package 
 * @see     
 */
class Client extends Person {
    private $email;

    public function __construct($nif, $name, $id, $email) {
        parent::__construct($nif, $name, $id);
        $this->email = $email;
    }

    public function __toString() {
        return parent::__toString()
                . "<br>Email: $this->email<br>";
    }
}