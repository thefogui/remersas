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

    public function getNif() {
        return $this->nif;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function __toString() {
        return "<tr><td>$this->id</td>"
                . "<td>$this->nif</td>"
                . "<td>$this->name</td>";
    }
}