<?php 

/**
 * Class that represents a person, it cotains the basic information to identify one person
 * @package 
 * @see     
 */
class Person {
    protected $nif;
    protected $name;
    private $id;

    public function __construct($nif, $name, $id) {
        $this->nif = $nif;
        $this->name = $name;
        $this->id = $id;
    }

    public function __toString() {
        return "<br>----------------------------------------------------------------"
                . "<br>NIF: $this->nif"
                . "<br>Nombre: $this->name";
    }
}