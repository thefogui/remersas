<?php 

/**
 * Class that are associated with the client factura
 * @package 
 * @see Client.php
 */
class Bill {
    private $id;
    private $value;
    private $date;
    private $code;

    public function __construct($value) {
        $this->value = $value;
    }

    public function Bill($value) {
        $this->value = $value;
    }

    public function __toString() {
        return "";
    }
}