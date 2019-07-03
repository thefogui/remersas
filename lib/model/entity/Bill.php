<?php 

/**
 * Class that are associated with the client factura
 * @package 
 * @see Client.php
 */
class Bill {
    private $value;

    public function __construct() {
        $args = func_get_args();

        if (count(args) > 0) {
            $this->Bill(args[0]);
        }
    }

    public function Bill($value) {
        $this->value = $value;
    }
}