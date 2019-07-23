<?php

require_once dirname(__FILE__) . "/../config/config.php";
include_once dirname(__FILE__) . '/../lib/model/dao/DaoClient.php';
require_once dirname(__FILE__) . "/Controller.php";

session_start();
//atributtes form

//functions

/**
 * function to send emails to the clients after read the json file
 * @param $file the name of the json file 
 * @source $source the folder that contains the json file
 */
function sendEmails($file, $source = "../cache/"){
    
    $appConfig = new AppConfig();
    $conn = $appConfig->connect( "populetic_form", "replica" );
    $daoClient = new DaoClient();

    $jsonData = file_get_contents($source . $file . ".json", 'r');
    $jsonArrayData = json_decode($jsonData, true);

    if ($jsonArrayData) {
        //check ../lib/dao/DaoClient.php yo see the other the data is saved
        //TODO: save the identify for each cow.
        foreach ($jsonArrayData as $user) {
            $email = $user[3];
            //TODO: check in the database if the email was sent to this user recently.
            $name = $user[1];
            $clientId = $user[2];
            $amount = $user[4];
            $ref = $user[5];
            $codigo_vuelo = $user[6];
            $lang = $user[7];
            $idReclamacio = $user[8];

            $daoClient->changeToSolicitarDatosPago($conn, $clientId);
            //$reclamacionID = $daoClient->getIdReclamacion($conn, $clientId);
            $daoClient->insertLogChange($conn, $clientId, $idReclamacio);

            $info = "";
            $hash = "";
            $date = date('Y-m-d H:i:s');
            $hash = Controller::getInstance()->generateHash($date, $idReclamacio);
            //TODO: save it in database how many time this email was sent
            $result = Controller::getInstance()->sendEmailValidation($info, $name, $email, $hash, $date, $ref, $lang, $codigo_vuelo);
        }
    } else 
        throw new Exception('Error reading emails');
    $appConfig->closeConnection($conn);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $file = 'clients';
        sendEmails($file);
        Controller::getInstance()->deleteJson($file, "../cache/");
        
    } catch (Exception $e) {
        echo $e;
    }
}

//TODO: change this text
$_SESSION['text'] = "Emails sent to the clients";

header("Location: ../apps/views/confirmation.php");