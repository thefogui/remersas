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

    public function __construct() {
        $args = func_get_args();

        if (count(args) > 0) {
            $this->ClientBankAccount(args[0], args[1], args[2]);
        }
    }

    public function ClientBankAccount($nif, $name, $IBAN, $titular, $billingAddress) {
        parent::__construct($nif, $name);

        $this->IBAN = $IBAN;
        $this->titular = $titular;
        $this->billingAddress = $billingAddress;
    }
}