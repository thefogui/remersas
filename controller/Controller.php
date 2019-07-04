<?php

class Controller {
    private static $instance;
    
    private function __construct() {}
    private function __clone() {}

    public static function getInstance() {
        if (!Controller::$instance instanceof self) {
            Controller::$instance = new self();
        }
        return Controller::$instance;
    }

    /**
     * This function saves a Json file suitn the array parameter
     * @param array thw array vector we want to create the json file
     * @param name the name of the jsson file
     * @param destination the folder that we gonna save the file
     */
    function arrayToJson($name, $array, $destination = "../cache/") {
        $fp = fopen($destination . $name . ".json", 'w');
        fwrite($fp, json_encode($array));
        fclose($fp);
    }
}