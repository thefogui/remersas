<?php

/**
 * Class 
 * @package 
 * @see     
 */
class DaoPerson {

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

    private function closeConnection() {
        mysqli_close($this->con);
    }

}