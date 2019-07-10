<?php

/**
 * Class to connect to the urltable
 */
class DaoUrlClient {
    private $conn;

    public function setConn($conn) {
        $this->conn = $conn;
    }

    public function getConn() {
        return $this->conn;
    }

    public function checkUrl($conn, $email, $hash) {
        $query = "SELECT * FROM emails WHERE email='" . $email . "'";

        $result = mysqli_query($conn, $query);

        if (!$query) {
            return false;
        }

        
        //TODO: check the data of the url inserted if is not valid return false

        return true;
    }
}