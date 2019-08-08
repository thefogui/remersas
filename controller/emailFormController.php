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
    $uncryptedHash = Controller::getInstance()->hashToActualData($hash);

    $generatedCode = Controller::getInstance()->generateUrlCodeValidation($email, $uncryptedHash["idReclamacion"]);
    $urlHash = $generatedCode['url'];
    
    $code = $generatedCode['code'];

    $refReclamacion = $uncryptedHash["idReclamacion"];

    Controller::getInstance()->sendEmailCode($info, $name, $email, $hash, $code, $refReclamacion);
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