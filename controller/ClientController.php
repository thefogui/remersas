<?php

include("Controller.php");

function validateCode() {
    $hash = $_POST['hash'];

    $formCode = $_POST['code'];

    $getCode = Controller::getInstance()->getDataFromUrlCode($hash);
    $code = $getCode['code'];
    $date = $getCode['date'];

    echo "dATE " . $date . " code_" . $code;
    if ($formCode != $code) {
        return false;
    }

    return !Controller::getInstance()->checkExpiredOneDay($date);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $validateFormData = validateCode();

    if ($validateFormData) {
        header("Location: ../apps/views/bankAccountForm.php");
    } else {
        unset ($_SESSION['text']);
        $_SESSION['text'] = "Error validation your code!";
        header("Location: ../apps/views/confirmation.php");
    }

    
}