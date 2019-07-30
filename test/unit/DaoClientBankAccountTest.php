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
}

$daoBillTest = new DaoClientBankAccountTest();
$daoBillTest->testInsertWithSwift();
$daoBillTest->testInsertWithOutSwift();