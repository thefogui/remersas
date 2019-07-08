<?php

require_once "../../lib/model/entity/UrlClient.php";

class UrlClientTest {

    function testGenerateHash() {
        echo "-------------------------------";
        echo "\n";
        echo "****Testing get the get the hash****";
        echo "\n";
        $date = date('Y-m-d H:i:s');
        $urlClient = new UrlClient(1, $date, "john@email.com");

        echo $urlClient->getHash();
        echo "\n";
        echo "-------------------------------";
        echo "\n";
    }

    function testHashToActualDate() {
        echo "-------------------------------";
        echo "\n";
        echo "****Testing get the date from hash****";
        echo "\n";
        $date = date('Y-m-d H:i:s');
        $urlClient = new UrlClient(12, $date, "john@email.com");

        echo $urlClient->getHash();
        echo "\n";
        echo $urlClient->hashToActualData();
        echo "\n";
        echo "-------------------------------";
        echo "\n";
    }

    function testCheckExpireDate() {
        echo "-------------------------------";
        echo "\n";
        echo "****Testing if the date is valid****";
        echo "\n";
        $date = date('Y-m-d H:i:s', strtotime("+1 week"));
        $urlClient = new UrlClient(13, $date, "john@email.com");

        if ($urlClient->checkExpireDate()) {
            echo "This url is valid!";
        } else {
            echo "This url has expired";
        }
        echo "\n";
        echo "-------------------------------";
        echo "\n";
    }

    function testGetUrl() {
        echo "-------------------------------";
        echo "\n";
        echo "Testing get the url";
        echo "\n";
        $date = date('Y-m-d H:i:s', strtotime("+1 week"));
        $urlClient = new UrlClient(3, $date, "john@email.com");

        echo $urlClient->getUrl();
        echo "\n";
        echo "-------------------------------";
        echo "\n";
    }
}

$urlClientTest = new UrlClientTest();
$urlClientTest->testGenerateHash();
$urlClientTest->testHashToActualDate();
$urlClientTest->testCheckExpireDate();
$urlClientTest->testGetUrl();