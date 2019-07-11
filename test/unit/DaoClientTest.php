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

        var_dump($daoUrl->getClients($conn, 500));
        echo "<br>";
        echo "-------------------------------";
        echo "<br>";
        $appConfig->closeConnection($conn);
    }
}

$daoBillTest = new DaoClientTest();
$daoBillTest->testGetMonth();
$daoBillTest->testGetClientsByMonth();
$daoBillTest->testgetClients();