<?php

require_once "../../config/config.php";
include_once '../../lib/model/dao/DaoClient.php';
include_once '../../lib/model/entity/Client.php';

class ClientTest {
    
    function testCreateClient() {
        $client = new Client("YXXXXXXY", "John Deo", 1, "john@email.com");
        echo $client;
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

        $this->printAll($clients);

        $appConfig->closeConnection($conn);
    }
    
}

$clientTest = new ClientTest();
$clientTest->testCreateClient();
$clientTest->testGetClientVip();

