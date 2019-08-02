<?php

require_once dirname(__FILE__) . "/../config/config.php";
include_once dirname(__FILE__) . '/../lib/model/dao/DaoClient.php';
include_once dirname(__FILE__) . '/../lib/model/dao/DaoClientBankAccount.php';
require_once dirname(__FILE__) . "/Controller.php";

session_start();
//atributtes form

//functions

function getJsonData($file, $source = "../cache/") {
    $jsonData = file_get_contents($source . $file . ".json", 'r');
    $jsonArrayData = json_decode($jsonData, true);

    $dictEmails = array();

    if ($jsonArrayData) {
        //check ../lib/dao/DaoClient.php yo see the other the data is saved
        foreach ($jsonArrayData as $client) {
            $dictEmails[$client["email"]][] = $client;
        }
    }

    return $dictEmails;
}

/**
 * function to send emails to the clients after read the json file
 * @param $file the name of the json file 
 * @source $source the folder that contains the json file
 */
function sendEmails($dictEmails) {
    $appConfig = new AppConfig();
    $conn = $appConfig->connect( "populetic_form", "replica" );
    $daoClient = new DaoClient();
    $daoClientBankAccount = new DaoClientBankAccount();

    foreach ($dictEmails as $email => $arrayClaimInfo) {
        $name;
        $clientId;
        $amount;
        $ref;
        $lang;
        $idReclamacio;
        $codigo_vuelo;
        $listClaimRefs = array();

        if (count($arrayClaimInfo) == 1) {
            //send email unic
            $name = $arrayClaimInfo[0]["name"];
            $clientId = $arrayClaimInfo[0]["idClient"];
            $amount = $arrayClaimInfo[0]["clientAmount"];
            $ref = $arrayClaimInfo[0]["referencia"];
            $lang = $arrayClaimInfo[0]["lang"];
            $idReclamacio = $arrayClaimInfo[0]["id_reclamacion"];
            $codigo_vuelo = $arrayClaimInfo[0]["codigo"];
            $daoClient->changeToSolicitarDatosPago($conn, $idReclamacio);
            $daoClient->insertLogChange($conn, $clientId, $idReclamacio, '36');
            
        } else {
            //send email with list of $clientInfo
            $name = $arrayClaimInfo[0]["name"];
            $clientId = $arrayClaimInfo[0]["idClient"];
            $amount = $arrayClaimInfo[0]["clientAmount"];
            $ref = $arrayClaimInfo[0]["referencia"];
            $lang = $arrayClaimInfo[0]["lang"];
            $idReclamacio = $arrayClaimInfo[0]["id_reclamacion"];
            $codigo_vuelo = $arrayClaimInfo[0]["codigo"];

            foreach ($arrayClaimInfo as $claimInfo) {
                $listClaimRefs[] = $claimInfo["referencia"];

                //if it is set it means is the principal claim.
                if (isset($claimInfo["listAssociates"])) {
                    $name = $claimInfo["name"];
                    $clientId = $claimInfo["idClient"];
                    $amount = $claimInfo["clientAmount"];
                    $ref = $claimInfo["referencia"];
                    $lang = $claimInfo["lang"];
                    $idReclamacio = $claimInfo["id_reclamacion"];
                    $codigo_vuelo = $claimInfo["codigo"];
                }
                $daoClient->changeToSolicitarDatosPago($conn, $idReclamacio);
                $daoClient->insertLogChange($conn, $clientId, $idReclamacio, '36');
            }
            
        }


        $hash = "";
        $date = date('Y-m-d H:i:s');
        $hash = Controller::getInstance()->generateHash($date, $idReclamacio);
        $result = Controller::getInstance()->sendEmailValidation($name, $email, $hash, $date, $amount,
                                                                 $ref, $lang, 
                                                                 $codigo_vuelo, $listClaimRefs);
        
        $daoClientBankAccount->updatePendingBankAccount($conn, $email, $idReclamacio);
        
        $appConfig->closeConnection($conn);
    }    
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $file = 'clients';
        $dictJsonData = getJsonData($file);
        
        sendemails($dictJsonData);
        
        Controller::getInstance()->deleteJson($file, "../cache/");
        
    } catch (Exception $e) {
        echo $e;
    }
}

//TODO: change this text
$_SESSION['text'] = "Emails sent to the clients";

header("Location: ../apps/views/confirmation.php");