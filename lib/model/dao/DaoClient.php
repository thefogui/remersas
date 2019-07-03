<?php

/**
 * Class to connect to the client table in the database
 * @package 
 * @see     
 */
class DaoClient {

    private $con;

    /**
     * Function to connect to the database
     * 
     * @see config/config.php
     */
    private function connect() {
        if(!$this->con = mysqli_connect($this->cfg->DBSERVER, $this->cfg->DBUSER, $this->cfg->PWD, $this->cfg->BD)) {
            return $this->response(true, "Error connecting to the database: " . mysqli_connect_error());
        } else{
            mysqli_set_charset($this->con, "utf8");
        }
    }

    /**
     * Class to close the connectiong with mysql
     */
    private function closeConnection() {
        mysqli_close($this->con);
    }

    /**
     * This function returns all the clients that has the state : 
     * 'solicitar datos pago'
     */
    private function getClientVip() {
        $state = 'solicitar datos pago';

        $response = $this->conectar();

        if($this->con) {
            $query = "SELECT " .
                     "FROM " .
                     "ON" .
                     "WHERE";
        }
    }

    
}