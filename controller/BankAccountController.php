<?php

include_once dirname(__FILE__) . '/../lib/model/dao/DaoClientBankAccount.php';
include_once dirname(__FILE__) . '/../lib/model/entity/ClientBankAccount.php';
require_once dirname(__FILE__) . "/../config/config.php";

class BankAccountController {
    private $daoClientBankAccount;

    public function __construct() {
       $this->daoClientBankAccount = new DaoClientBankAccount();
    }

    //TODO: call the daoCLIENT FUNCTION TO INSERT IT INTO THE DATABASE
    public function insertData() {
        $appConfig = new AppConfig();

        $conn = $appConfig->connect("populetic_form", "localhost"); //connect to the sql databse
        // Check connection
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        
        //$result = $this->daoClientBankAccount->insert();

        $appConfig->closeConnection($conn); //close the connection
    }

    public function redirectToInfoPage() {

    }
}

