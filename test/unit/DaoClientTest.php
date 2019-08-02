<?php

require_once "../../lib/model/dao/DaoClient.php";
require_once "../../lib/model/entity/Client.php";
require_once "../../config/config.php";

class DaoClientTest {
    function testGetMonth() {
        echo "-------------------------------";
        echo "\n";
        echo "Testing get the month";
        echo "\n";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $daoUrl = new DaoClient();

        echo $daoUrl->getTheOldestMonth($conn)["month"];
        echo "\n";
        echo "-------------------------------";
        echo "\n";
        $appConfig->closeConnection($conn);
    }

    function testGetClientsByMonth() {
        echo "-------------------------------";
        echo "\n";
        echo "Testing get the clients by month";
        echo "\n";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $daoUrl = new DaoClient();

        var_dump($daoUrl->getClientsByMonth($conn, '6', 50000));
        echo "\n";
        echo "-------------------------------";
        echo "\n";
        $appConfig->closeConnection($conn);
    }

    function testgetClients() {
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        echo "Testing get clients";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $daoUrl = new DaoClient();

        var_dump($daoUrl->getClients($conn, 50000.786));
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }

    function testChangeToSolicitarDatosPago() {
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        echo "Testing changeToSolicitarDatosPago()";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $dao = new DaoClient();

        var_dump($dao->changeToSolicitarDatosPago($conn, 29));
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }

    function testgetIdReclamacion() {
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        echo "Testing changeToSolicitarDatosPago()";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $dao = new DaoClient();

        var_dump($dao->getIdReclamacion($conn, 29));
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }

    function testInsertLogChange() {
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        echo "Testing Insert Log Change";
        echo "<br>";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $dao = new DaoClient();

        var_dump($dao->insertLogChange($conn, 29, 51));
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }

    function testGetClaimsRealted() {
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        echo "Testing Insert Log Change";
        echo "<br>";
        $appConfig = new AppConfig();
        $daoClient = new DaoClient();

        $conn = $appConfig->connect( "populetic_form", "replica" );
        
        $emailClaim =  "vitor.carvalho@populetic.com";

        $idClaim = 536;

        var_dump($daoClient->getAllCalims($conn, $emailClaim, $idClaim));
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
    }
}

$daoClient = new DaoClientTest();
//$daoClient->testGetMonth();
//$daoClient->testGetClientsByMonth();
//$daoClient->testChangeToSolicitarDatosPago();
//$daoClient->testgetIdReclamacion();
//$daoClient->testInsertLogChange();
$daoClient->testGetClaimsRealted();