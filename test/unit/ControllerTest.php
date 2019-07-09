<?php

require_once "../../controller/Controller.php";

class ControllerTest {

    function testSendEmail() {
        echo "-------------------------------";
        echo "\n";
        Controller::getInstance()->sendEmail("", "vitor", "vitor.carvalho@populetic", "OQWHLJFAMWSBFAJBFAÑJBFÑAMBWQJRBQWJLR");
        echo "\n";
        echo "-------------------------------";
        echo "\n";
    }

    function testEncryptFunction() {
        echo "-------------------------------";
        echo "\n";
        echo "****Testing encrypt text ****";
        echo "\n";
        echo Controller::getInstance()->encryptText("AD1200012030200359100100");
        echo "\n";
        echo "-------------------------------";
        echo "\n";
    }

    function testDecryptText() {
        echo "-------------------------------";
        echo "\n";
        echo "****Testing decryptText ****";
        echo "\n";
        echo Controller::getInstance()->decryptText(Controller::getInstance()->encryptText("AD1200012030200359100100"));
        echo "\n";
        echo "-------------------------------";
        echo "\n";
    }
}

$controllerTest = new ControllerTest();
$controllerTest->testEncryptFunction();
$controllerTest->testDecryptText();