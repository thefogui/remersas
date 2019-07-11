<?php

require_once "../../lib/model/dao/DaoUrlClient.php";
require_once "../../config/config.php";

class VerifyController {
    
    /** 
     * Function to check the url that was sent to user email
     * @return true if the url is valid false otherwise
     */
    function checkClientUrl($email, $hash) {
        $daoUrlClient = new DaoUrlClient();
        $appConfig = new AppConfig();

        $conn = $appConfig->connect("populetic_form", "localhost");

        $urlCheckResult = $daoUrlClient->checkClientUrl($conn, $email, $hash);

        $appConfig->closeConnection($conn);
        return $urlCheckResult;
    }
}