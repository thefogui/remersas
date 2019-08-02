<?php

session_start();

include(dirname(__FILE__) . "/Controller.php");

function validateCode($hash) {
    $formCode = $_POST['code'];

    $getCode = Controller::getInstance()->getDataFromUrlCode($hash);
    $code = $getCode['code'];
    
    if ($formCode != $code) return false;
    
    $date = $getCode['date'];
    
    $emailClaim = $getCode['email'];
    $idClaim = $getCode['idReclamacion'];

    $_SESSION["claims"] = Controller::getInstance()->getListOfClaims($emailClaim, $idClaim);

    return !Controller::getInstance()->checkExpiredOneDay($date);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hash = $_POST['hash'];
    $validateFormData = validateCode($hash);

    if ($validateFormData) 
        header("Location: ../apps/views/bankAccountForm.php?hash=" . $hash);
    else 
        Controller::getInstance()->rediectToInfoPage("Your code is not correct!");
}