<?php 

require_once "Person.php";

/**
 * Class that are associated with the client information
 * @package 
 * @see     
 */
class Client extends Person {
    private $email;
    private $city;
    private $address;

	public function getEmail() {
        return $this->email;
    }

    public function __construct($nif, $name, $id, $email) {
        parent::__construct($nif, $name, $id);
        $this->email = $email;
    }

    /**
     * public function __construct() {
     * $parameters = func_get_args();
     * ...
     * }
     * @param $values
     * @param $id
     * @return Client
     */
    public static function constructWithArray($values, $id) {
	    $name = $values["name"] . " " . $values["surname"];
        $instance = new self($values["dni"], $name, $id, $values["email"]);
        $instance->fill($values);
        return $instance;
    }

    private function fill( array $values ) {
        // fill all properties from array
        $this->address = $values["address"];
        $this->city = $values["city"];
    }

    /**
     * @return mixed
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city) {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address) {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getNif() {
        return $this->nif;
    }

    /**
     * @param mixed $nif
     */
    public function setNif($nif) {
        $this->nif = $nif;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Function to calculate the amount of money is need to play to a client
     * La fórmula para calcular la cantidad a pagar a cada cliente es: (cantidad_obtenida x 0.25) x 1.21
     * @param int $amountReviewed
     * @param float $iva
     * @param float $commission
     * @return float|int
     */
    public function amountToPay($amountReviewed = 0, $iva = 0.21, $commission = 0.25) {

        $amountClient = $amountReviewed - ($amountReviewed * $commission) - ($amountReviewed * $iva);

        return $amountClient;
    }

    public function __toString() {
        return parent::__toString()
                . "<td>$this->email</td></tr>";
    }
}