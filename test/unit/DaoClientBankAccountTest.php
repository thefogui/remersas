<?php

require_once "../../lib/model/dao/DaoClientBankAccount.php";
require_once "../../config/config.php";

class DaoClientBankAccountTest {
    function testInsertWithSwift() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing iserting the client bank account";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $daoUrl = new DaoClientBankAccount();

        $account_number = "ES3436536436346346";
        $swift = "1213142312";
        $account_holder = "Vitor Carvalho";
        $billing_address = "somewhere in Sabadell";
        $email_client = "vitor.carvalho@populetic.com";
        $id_claim = 537;
        $phone_client = "93 99894 9992";

        try {
            $daoUrl->insert($conn, $account_number, $account_holder, $billing_address, $email_client, $phone_client, $id_claim, $swift);
        } catch (Exception $e) {
            echo $e;
        }

        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }

    function testInsertWithOutSwift() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing iserting the client bank account";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $daoUrl = new DaoClientBankAccount();

        $account_number = "ES3436536436346346";

        $account_holder = "Vitor Carvalho";
        $billing_address = "somewhere in Sabadell";
        $email_client = "vitor.carvalho@populetic.com";
        $id_claim = 537;
        $phone_client = "93 99894 9992";

        try {
            $daoUrl->insert($conn, $account_number, $account_holder, $billing_address, $email_client, $phone_client, $id_claim);
        } catch (Exception $e) {
            echo $e;
        }

        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }

    public function testInsertIntoPendingBankAccount() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing iserting into pending_bank_account";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $dao = new DaoClientBankAccount();

        $emailClaim = "vitor.carvalho@populetic.com";
        $idClaim = 537;
        
        try {
            $dao->insertIntoPendingBankAccount($conn, $emailClaim, $idClaim);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function testchangeStateToWithoutBankAccount() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing chaning the state to without Bank Account";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $dao = new DaoClientBankAccount();

        $idClaim = 537;
        
        try {
            $dao->changeStateToWithoutBankAccount($conn, $idClaim);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function testDeletePendingBankAccount() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing deletiong an entry by the email";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $dao = new DaoClientBankAccount();

        $emailClaim = "vitor.carvalho@populetic.com";
        
        try {
            $dao->deletePendingBankAccount($conn, $emailClaim);
        } catch (Exception $e) {
            echo $e;
        }

        echo "<br>";
        echo "-------------------------------";
    }

    public function testUpdateTimesSentTheEmail() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing updating the time the email was sent";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $dao = new DaoClientBankAccount();

        $emailClaim = "vitor.carvalho@populetic.com";
        
        try {
            $dao->updateTimesSentTheEmail($conn, $emailClaim);
        } catch (Exception $e) {
            echo $e;
        }

        echo "<br>";
        echo "-------------------------------";
    }

    public function testupdatePendingBankAccount() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing updating the pending bankAccount";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $dao = new DaoClientBankAccount();

        $emailClaim = "vitor.carvalho@populetic.com";
        $idClaim = 537;
        
        try {
            $dao->updatePendingBankAccount($conn, $emailClaim, $idClaim);
        } catch (Exception $e) {
            echo $e;
        }

        echo "<br>";
        echo "-------------------------------";
    }
}

$daoBillTest = new DaoClientBankAccountTest();
//$daoBillTest->testInsertWithSwift();
//$daoBillTest->testInsertWithOutSwift();
//$daoBillTest->testInsertIntoPendingBankAccount();
//$daoBillTest->testchangeStateToWithoutBankAccount();
//$daoBillTest->testDeletePendingBankAccount();
//$daoBillTest->testUpdateTimesSentTheEmail();
//$daoBillTest->testupdatePendingBankAccount();