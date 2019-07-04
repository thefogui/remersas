<?php 

/**
 * Class that are associated with the client Bank Account
 * @package 
 * @see Client.php
 */
class ClientBankAccount extends Person {
    private $IBAN;
    private $titular;
    private $billingAddress;

    public function __construct($IBAN, $titular, $billingAddress) {
        $this->IBAN = $IBAN;
        $this->titular = $titular;
        $this->billingAddress = $billingAddress;
    }

    public function __toString() {
        return "";
    }
}