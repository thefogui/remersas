<?php 

/**
 * Class that are associated with the client Bank Account
 * @package 
 * @see Client.php
 */
class ClientBankAccount extends Person {
    private $id;
    private $IBAN;
    private $titular;
    private $billingAddress;

    public function __construct($id, $IBAN, $titular, $billingAddress) {
        $this->id = $id;
        $this->IBAN = $IBAN;
        $this->titular = $titular;
        $this->billingAddress = $billingAddress;
    }

    public function getIBAN() {
        return $this->IBAN;
    }

    public function __toString() {
        return "";
    }
}