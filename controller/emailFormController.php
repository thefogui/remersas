<?php

require_once dirname(__FILE__) . "/../config/config.php";

include(dirname(__FILE__) . "/Controller.php");

session_start();
//atributtes form
$conn;

//functions

/**
 * 
 */
function sendEmailCode($email){
    //TODO: get url
    $url = "localhost/remesas/";
    //TODO: check if the user has
    $generatedCode = Controller::getInstance()->generateUrlCodeValidation($email);
    $urlHash = $generatedCode['url'];
    $code = $generatedCode['code'];

    Controller::getInstance()->sendEmailCode($info, $name, $email, $hash, $code);
    return $urlHash;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    try {
        $hash = sendEmailCode($email);
        header("Location: ../apps/views/codeForm.php?email=" . $email . "&hash=". $hash);
    } catch (Exception $e) {
        echo $e;
    }
}