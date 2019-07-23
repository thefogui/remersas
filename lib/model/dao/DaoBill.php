<?php

/**
 * Class used to crud the bill class
 * @see Bill.php
 */
class DaoBill {
    private $conn;

    public function setConn($conn) {
        $this->conn = $conn;
    }

    public function getConn() {
        return $this->conn;
    }
}