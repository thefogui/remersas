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

    /**
     * Function to delete a json file
     * be carefull using it 
     * 
     * @param $name file name
     * @param $source file source folder
     * @exception throws an exception if the file does not exist
     */
    function deleteJson($name, $source = "../cache/") {
        $fileRouter = $source . $name . '.json';
        if (file_exists($fileRouter)) {
            unlink($fileRouter);
        } else {
            throw new Exception('Error deleting file: ' . $fileRouter .' does not exist!');
        }
    }

    /**
     * Function to send an email to an user
     * 
     * @param $info
     * @param $name 
     * @param $email 
     * @param $hash
     */
    function sendEmail($info, $name, $email, $hash) {
        //TODO: remove if 

        //check if the email extension is a populetic email.
        preg_match('/(\S+)(@(\S+))/', $email, $match);
        $emailExtension = $match[2];
 
        if ($emailExtension == "populetic") {
            
            $to      = $email; // Send email to our user
            $subject = 'Signup | Verification'; // Give the email a subject 
            $message = '
            
            Hello from team Populetic, 
            Zombie ipsum reversus ab viral inferno' . $name . ', nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus brains sit​​, morbo vel maleficia? De apocalypsi gorger omero undead survivor dictum mauris. Hi mindless mortuis soulless creaturas, imo evil stalking monstra adventus resi dentevil vultus comedat cerebella viventium. Qui animated corpse, cricket bat max brucks terribilem incessu zomby.
            
            Please click this link to activate your account:
            localhost/remesas/apps/views/verify.php?email=' . $email.'&hash=' . $hash . '
            
            '; // Our message above including the link
                                
            $headers = 'From:noreply@populetic.com' . "\r\n"; // Set from headers
            mail($to, $subject, $message, $headers); // Send our email    
        } 
    }

    /**
     * Function to encrypt a text
     * @param $value the text we want to encript
     * 
     */
    function encryptText($text) {
        if(!$text) 
            return false;

        //TODO: change the secret key
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'BHEJLNWWQVQWGJSQS52D1QW32E52XWQE8';
        $secret_iv = 'BHEJLNWWQVQWGJSQS52D1QW32E52XWQE8';

        $key = hash('sha256', $secret_key);
    
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
   
        $crypttext = openssl_encrypt($text, $encrypt_method, $key, 0, $iv);

        return base64_encode($crypttext);
    }

    /**
     * Function to decrypt a encrypt text
     * @param the text encrypt
    */
    function decryptText($encryptedText) {
        if(!$encryptedText) 
            return false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'BHEJLNWWQVQWGJSQS52D1QW32E52XWQE8';
        $secret_iv = 'BHEJLNWWQVQWGJSQS52D1QW32E52XWQE8';

        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        return openssl_decrypt(base64_decode($encryptedText), $encrypt_method, $key, 0, $iv);
    }   
}