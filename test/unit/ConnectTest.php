<?php

require_once "../../config/config.php";

class ConnectTest {
    
    /**
     * this function connects to the sql database and close the connetion
     */
    function testCase() {
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        echo "Connected successfully";
        $appConfig->closeConnection($conn);
    }
}

$connect = new ConnectTest();
$connect->testCase();