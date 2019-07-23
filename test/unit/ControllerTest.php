<?php

require_once "../../controller/Controller.php";

class ControllerTest {

    function testSendEmail() {
        echo "-------------------------------";
        echo "\n";
        echo Controller::getInstance()->sendEmailValidation("", "vitor", "vitor.carvalho@populetic.com", "OQWHLJFAMWSBFAJBFAÑJBFÑAMBWQJRBQWJLR");
        echo "\n";
        echo "-------------------------------";
        echo "\n";
    }

    function testEncryptFunction() {
        echo "-------------------------------";
        echo "\n";
        echo "****Testing encrypt text ****";
        echo "\n";
        echo Controller::getInstance()->encryptText(date('Y-m-d H:i:s'));
        echo "\n";
        echo "****Testing encrypt  url ****";
        echo "\n";
        echo Controller::getInstance()->generateHash(date('Y-m-d H:i:s'));
        echo "\n";
        echo "-------------------------------";
        echo "\n";
    }

    function testDecryptText() {
        echo "-------------------------------";
        echo "\n";
        echo "****Testing decryptText ****";
        echo "\n";
        echo Controller::getInstance()->decryptText("cjRRQWFIT1FvVUlHaS9oT0JIZ3NLbGpOcTZHbWhrcFZodS9GTWw5c2NPcz0=");
        echo "\n";
        echo "-------------------------------";
        echo "\n";
    }

    function testcheckUrl()
    {
        echo "-------------------------------";
        echo "\n";
        echo "****Testing eheckurl ****";
        echo "\n";
        echo Controller::getInstance()->checkurl("", "");
        echo "\n";

        echo "testing a valid entry --->";
        echo Controller::getInstance()->checkurl("", "");
        echo "\n";

        echo "testing a invalid entry --->";
        echo Controller::getInstance()->checkurl("", "");
        echo "\n";

        echo "testing a existent query --->";
        echo Controller::getInstance()->checkurl("", "");
        echo "\n";

        echo "testing a inexistent query --->";
        echo Controller::getInstance()->checkurl("", "");
        echo "\n";

        echo "-------------------------------";
        echo "\n";
    }

    function testUrlValidation() {
        echo "-------------------------------";
        echo "<br>";
        echo "**** Testing get Url ****";
        echo "<br>";
        $result = Controller::getInstance()->generateUrlCodeValidation();
        echo  $result['url'];
        echo "<br>";
        
        echo  $result['code'];
        echo "<br>";

        $result2 = Controller::getInstance()->getDataFromUrlCode($result['url']);
        echo  "date:" . $result2['date'];
        echo "<br>";
        
        echo  $result2['code'];
        echo "<br>";

        if (Controller::getInstance()->checkExpiredOneDay($result2['date'])) {
            echo "not valid";
            echo "<br>";
        } else {
            echo "valid";
            echo "<br>";
        }

        $yesterday = date("Y-m-d H:i:s", time() - 86442);

        echo "date y:" . $yesterday;
        echo "<br>";

        if (Controller::getInstance()->checkExpiredOneDay($yesterday)) {
            echo "not valid";
            echo "<br>";
        } else {
            echo "valid";
            echo "<br>";
        }
    }
}

$controllerTest = new ControllerTest();
/*$controllerTest->testEncryptFunction();
$controllerTest->testDecryptText();
$controllerTest->testSendEmail();*/
$controllerTest->testUrlValidation();
