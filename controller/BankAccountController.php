<?php

include_once dirname(__FILE__) . '/../lib/model/dao/DaoClientBankAccount.php';
include_once dirname(__FILE__) . '/../lib/model/entity/ClientBankAccount.php';
require_once dirname(__FILE__) . "/../config/config.php";

/**
 * Class BankAccountController
 */
class BankAccountController {
    private $daoClientBankAccount;

    public function __construct() {
       $this->daoClientBankAccount = new DaoClientBankAccount();
    }

    public function insertDataIntoBankAccountDataBase() {
        $swift     = "";
        $appConfig = new AppConfig();

        $account_number = Controller::getInstance()->encryptText($_POST["account_number"]);

        if (isset($_POST["swift"]))
            $swift =  Controller::getInstance()->encryptText($_POST["swift"]);
        
        $account_holder  = Controller::getInstance()->encryptText($_POST["titular"]);
        $billing_address = Controller::getInstance()->encryptText($_POST["address"]);
        $email_client    = Controller::getInstance()->encryptText($_POST["email"]);
        $id_claim        = Controller::getInstance()->encryptText($_SESSION['id_claim']);
        $phone_client    = Controller::getInstance()->encryptText($_POST["phone"]);

        $conn = $appConfig->connect("populetic_form", "localhost"); //connect to the sql database
        
        // Check connection
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        
        try {
            $this->daoClientBankAccount->insert($conn, $account_number, $account_holder, $billing_address, $email_client,
                                                $phone_client, $id_claim, $swift);
        }  catch (Exception $e) {
            $message = 'Error inserting data in sql: ';
            $message .=  $e->getMessage() . "<br>";
            $this->redirectToInfoPage($message);
        }

        //TODO: change this interaction
        $message = "Tus datos han sido guardados con exito, ya nos pondremos en contacto etc";
        $this->redirectToInfoPage($message);

        $appConfig->closeConnection($conn); //close the connection
    }

    public function redirectToInfoPage($message) {
        unset($_SESSION['text']);
        $_SESSION['text'] = $message;
        header("Location: confirmation.php");
    }
}