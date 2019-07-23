<?php

require_once "../../lib/model/dao/DaoBill.php";
require_once "../../config/config.php";

class DaoBillTest {
    function testGetMonth() {
        echo "-------------------------------";
        echo "\n";
        echo "Testing get the month";
        echo "\n";
        $appConfig = new AppConfig();
        $conn = $appConfig->connect( "populetic_form", "replica" );
        $daoUrl = new DaoBill();

        echo $daoUrl->getTheOldestMonth($conn);
        echo "\n";
        echo "-------------------------------";
        echo "\n";
        $appConfig->closeConnection($conn);
    }
}

$daoBillTest = new DaoBillTest();
$daoBillTest->testGetMonth();