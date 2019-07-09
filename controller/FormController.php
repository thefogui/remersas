<?php

require_once "../config/config.php";
include_once '../lib/model/dao/DaoClient.php';
include_once '../lib/model/entity/Client.php';
include("Controller.php");

//atributtes form
$amount = "";
$conn;


//functions

/**
 * This function reads the databse and get the clients with vip status
 * 
 * @param $amount amount of money the user speciefied in the form
 */
function getVipClients($amount) {
    $daoClient = new DaoClient();
    $appConfig = new AppConfig();
    
    $conn = $appConfig->connect( "populetic_form", "localhost" ); //connect to the sql databse
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $resultQuery = $daoClient->getClientVip($conn, $amount); //clients, ammountLeft, amountToPay

    $clients = $resultQuery[0];

    $_POST["amountLeft"] = $resultQuery[1];
    $_POST["amountToPay"] = $resultQuery[2];

    $appConfig->closeConnection($conn); //close the connection

    return $clients;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
    
    $clientsVips = getVipClients($amount);
    Controller::getInstance()->arrayToJson("clientsvip", $clientsVips);
}

header("Location: ../apps/views/clientList.php?amount=" . $amount);