<?php

require_once "../../lib/model/dao/DaoInvoice.php";
require_once "../../config/config.php";

class DaoInvoiceTest {
    function getInvoke() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing get the invoke data from sql";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "halbrand", "replica" );
        $daoInvoke = new DaoInvoice($conn);

        $claimId = "2528";

        try {
            var_dump($daoInvoke->getInvoiceData($claimId));
        } catch (Exception $e) {
            echo $e;
        }
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }

    function getClaimTest() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing get the claim data from sql";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $daoInvoke = new DaoInvoice($conn);

        $claimId = "493";

        try {
            var_dump($daoInvoke->getClaim($claimId));
        } catch (Exception $e) {
            echo $e;
        }
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }

    function getClientTest() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing get the cliente data from sql";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $daoInvoke = new DaoInvoice($conn);

        $clientId = "211";

        try {
            var_dump($daoInvoke->getClient($clientId));
        } catch (Exception $e) {
            echo $e;
        }
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }

    function getBillingPreferencesTest() {
        echo "-------------------------------";
        echo "<br>";
        echo "Testing get the billing preference data from sql";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "halbrand", "replica" );
        $daoInvoke = new DaoInvoice($conn);

        try {
            var_dump($daoInvoke->getBillingPreferences());
        } catch (Exception $e) {
            echo $e;
        }
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }
}

$daoBillTest = new DaoInvoiceTest();
$daoBillTest->getInvoke();
$daoBillTest->getClaimTest();
$daoBillTest->getClientTest();
$daoBillTest->getBillingPreferencesTest();