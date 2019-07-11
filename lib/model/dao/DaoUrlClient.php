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

    public function checkClientUrl($conn, $email, $hash) {
        /*$query = "SELECT * FROM emails WHERE email='" . $email . "'";

        $result = mysqli_query($conn, $query);

        if (mysqli_errno($conn)) {
            throw new Exception('Error getting the url: ' . mysqli_error($conn));
        }*/

        
        //TODO: check the data of the url inserted if is not valid return false

        return true;
    }
}