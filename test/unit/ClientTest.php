<?php

include_once '../../lib/model/DaoClient.php';
include_once '../../lib/model/Client.php';

class ClientTest {
    
    /**
     * Test get all clients with vip state 
     * @see DaoClient.php
     */
    function testGetClientVip() {
        $appConfig = new AppConfig();
        $daoClient = new DaoClient();
        $client = new Client();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        echo "Connected successfully";

        
        $clients = $daoClient->getClientVip($conn);

        printAll($clients);

        $appConfig->closeConnection($conn);
    }

    /**
     * Function to print all elements in an array
     * @param array and array vector
     */
    function printAll($array) {
        foreach ($array as $element) {
            echo $element;
    }
}
}

$connect = new ConnectTest();
$connect->testCase();

