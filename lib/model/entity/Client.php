<?php 

require_once "Person.php";

/**
 * Class that are associated with the client information
 * @package 
 * @see     
 */
class Client extends Person {
    private $email;

	public function getEmail() {
        return $this->email;
    }

    public function __construct($nif, $name, $id, $email) {
        parent::__construct($nif, $name, $id);
        $this->email = $email;
    }

    /**
     * Function to calculate the amount of money is need to play to a client
     * La fórmula para calcular la cantidad a pagar a cada cliente es: (cantidad_obtenida x 0.25) x 1.21
     */
    public function amountToPay($amountReviewed = 0, $iva = 1.21, $commission = 0.25) {
        $amountClient = 0.;

        $amountClient = $amountReviewed - ($amountReviewed * $commission) * $iva;

        return $amountClient;
    }

    public function __toString() {
        return parent::__toString()
                . "<td>$this->email</td></tr>";
    }
}