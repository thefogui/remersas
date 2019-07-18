<?php

require_once dirname(__FILE__) . "/../config/config.php";
include_once dirname(__FILE__) . '/../lib/model/dao/DaoClient.php';
include_once dirname(__FILE__) . '/../lib/model/entity/Client.php';
include(dirname(__FILE__) . "/Controller.php");

session_start();
//atributtes form
$amount = "";
$conn;


//functions

/**
 * This function reads the databse and get the clients with vip status
 * 
 * @param $amount amount of money the user speciefied in the form
 */
function getClients($amount) {
    $daoClient = new DaoClient();
    $appConfig = new AppConfig();
    
    $conn = $appConfig->connect( "populetic_form", "localhost" ); //connect to the sql databse
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $resultQuery = $daoClient->getClients($conn, $amount); //clients, ammountLeft, amountToPay

    $clients = $resultQuery['clients'];

    $_SESSION["amountLeft"] = $resultQuery["amountLeft"];
    $_SESSION["amountToPay"] = $resultQuery["amountToPay"];
    $_SESSION["numClients"] = $resultQuery["totalClients"];
    $_SESSION["numVips"] = $resultQuery["numVips"];

    $appConfig->closeConnection($conn); //close the connection

    return $clients;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
    
    $clients = getClients($amount);

    Controller::getInstance()->arrayToJson("clients", $clients);
}

header("Location: ../apps/views/clientList.php?amount=" . $amount);