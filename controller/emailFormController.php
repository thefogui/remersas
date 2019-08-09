<?php

require_once dirname(__FILE__) . "/../config/config.php";

include(dirname(__FILE__) . "/Controller.php");

session_start();
//atributtes form

//functions

/**
 * 
 */
function sendEmailCode($email, $hash){
    $name = "";
    $uncryptedHash = Controller::getInstance()->hashToActualData($hash);
    $refReclamacion = $uncryptedHash["idReclamacion"];

    $generatedCode = Controller::getInstance()->generateUrlCodeValidation($email, $uncryptedHash["idReclamacion"]);
    $urlHash = $generatedCode['url'];
    $code = $generatedCode['code'];

    try {
        $name = Controller::getInstance()->getUserNameByClaimRef($refReclamacion);
    } catch (Exception $e) {
        //TODO: redirect to error handler
    }

    Controller::getInstance()->sendEmailCode($name, $email, $code, $refReclamacion);
    return $urlHash;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $hash = $_POST['hash'];
    try {
        $hash = sendEmailCode($email, $hash);
        header("Location: ../apps/views/codeForm.php?email=" . $email . "&hash=". $hash);
    } catch (Exception $e) {
        echo $e;
    }
}