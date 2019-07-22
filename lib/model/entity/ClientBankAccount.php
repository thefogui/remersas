<?php 

/**
 * Class that are associated with the client Bank Account
 * @package 
 * @see Client.php
 */
class ClientBankAccount {
    private $id;
    private $IBAN;
    private $titular;
    private $swift;
    private $billingAddress;

    public function __construct($id, $IBAN, $titular, $billingAddress, $swift) {
        $this->id = $id;
        $this->IBAN = $IBAN;
        $this->titular = $titular;
        $this->billingAddress = $billingAddress;
        $this->swift = $swift;
    }

    public function getIBAN() {
        return $this->IBAN;
    }

    public function __toString() {
        return "";
    }
}