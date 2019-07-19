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
    function sendEmailValidation($info, $name, $email, $hash, $date, $amount=0, $ref="MARIA SU", $languageId='es', $codigo= "not defined") {
        $correo = $this->initPHPMailer();
        $mandrill = $this->initMandrill();
        $templateSubject = "_(¡Hemos conseguido su indemnización! índiquenos dónde desea recibirla)";    
        $result = "Nothing";
    
        $emailInfo[] = array(
            "email" => utf8_encode($email),
            "name" => utf8_encode($name),
            "amount" => utf8_encode($amount),
            "hash" => utf8_encode($hash),
            "codigo" => utf8_encode($codigo)
        );

        try {
            sendMandrillBatchMail($mandrill, $ref, $email, 'correo_verificación_datos_bancarios_' . $languageId, $templateSubject, $emailInfo, 0);
            $result = "Error no";
        } catch(Mandrill_Error $e) {
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            $result = "Error yes";
            throw $e;
        }
        
        //TODO: remove code below
        $result = "Nothing";
        preg_match('/(\S+)(@(\S+))/', $email, $match);
        $emailExtension = $match[2];
        
        $to      = $email; // Send email to our user
        $subject = '¡Hemos conseguido su indemnización! índiquenos dónde desea recibirla'; // Give the email a subject 
        $body = '
        
        Hello from team Populetic, 
        Zombie ipsum reversus ab viral inferno' . $name . ', nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus brains sit​​, morbo vel maleficia? De apocalypsi gorger omero undead survivor dictum mauris. Hi mindless mortuis soulless creaturas, imo evil stalking monstra adventus resi dentevil vultus comedat cerebella viventium. Qui animated corpse, cricket bat max brucks terribilem incessu zomby.
        
        Please click this link to activate your account:
        localhost/remesas/apps/views/verify.php?email=' . $email.'&hash=' . $hash . '
        
        '; // Our message above including the link
                            
        $correo->Subject = $subject;   
        $correo->MsgHTML($body);
        $correo->AddAddress($to, "Populetic");

        if( !$correo->Send() ) 
            $result= "Error yes";
        else 
            $result= "Error no";
        return $result;
    }

    function sendEmailCode($info, $name, $email, $hash, $code) {
        //TODO: edit email;
        $correo = $this->initPHPMailer();

        $result = "Nothing";
        //check if the email extension is a populetic email.
        
        $to      = $email; // Send email to our user
        $subject = 'Populetic | Email Verification'; // Give the email a subject 
        $body = '
        
        Hello from team Populetic, 
        Zombie ipsum reversus ab viral inferno' . $name . ', nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus brains sit​​, morbo vel maleficia? De apocalypsi gorger omero undead survivor dictum mauris. Hi mindless mortuis soulless creaturas, imo evil stalking monstra adventus resi dentevil vultus comedat cerebella viventium. Qui animated corpse, cricket bat max brucks terribilem incessu zomby.
        
        YOUR CODE IS: ' .  $code . '
        
        '; // Our message above including the link
                            
        $correo->Subject = $subject;   
        $correo->MsgHTML($body);
        $correo->AddAddress($to, "Populetic");

        if( !$correo->Send() )
            $result= "Error yes";
        else 
            $result= "Error no";
        return $result;
    }

    /**
     * Function to encrypt a text
     * @param $value the text we want to encript
     * 
     */
    function encryptText($text) {
        if(!$text) 
            return false;

        //TODO: change the secret key (Something encrypted in the database...)
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

    function initPHPMailer() {
        date_default_timezone_set('Etc/UTC');

        require_once( dirname(__FILE__) . '/../plugins/phpmailer/PHPMailerAutoload.php');
        require_once( dirname(__FILE__) . '/../plugins/phpmailer/class.phpmailer.php');
        
        //Create a new PHPMailer instance
        $correo = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $correo->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $correo->SMTPDebug = 0;
        //Ask for HTML-friendly debug output
        $correo->Debugoutput = 'html';
        //Set the hostname of the mail server
        $correo->Host = 'smtp.gmail.com';
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $correo->Port = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $correo->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $correo->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $correo->Username = "populetic.test@gmail.com";
        //Password to use for SMTP authentication
        $correo->Password = "populetic123";

        return $correo;
    }

    private function initMandrill() {
        require_once( dirname(__FILE__) . "/../plugins/mandrill/mandrill.php");

        $mandrill = new Mandrill('vrjSix_nhICY9pQa2gnYtQ');

        return $mandrill;
    }

    public function generateHash($expireDate) {
        return base64_encode(bin2hex($expireDate));
    }

    /**
     * Function to get the expire date from hash url
     * 
     */
    public function hashToActualData($hash) {
        $uncriptedHash = hex2bin(base64_decode($hash));        
        return $uncriptedHash;
    }

    /**
     * Function to check the expire date of the actual url
     * 
     * @return true if the url still valid and false otherwise
     */
    public function checkExpireDate($date) {
        if (DateTime::createFromFormat('Y-m-d H:i:s', $date) !== FALSE) {
            $exp_date = strtotime($date . '+7 days');        
            $today    = date("Y-m-d H:i:s");
            $tsToday  = strtotime($today);
            return ($tsToday > $exp_date);
        }
        return true;
    }

    public function checkExpiredOneDay($date) {
        if (DateTime::createFromFormat('Y-m-d H:i:s', $date) !== FALSE) {
            $exp_date = strtotime($date . '+1 days');        
            $today    = date("Y-m-d H:i:s");
            $tsToday  = strtotime($today);

            return ($tsToday > $exp_date);
        }
        return true;
    }

    public function uniqidReal($lenght = 13) {
        // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return strtoupper(substr(bin2hex($bytes), 0, $lenght));
    }

    public function generateUrlCodeValidation($email) {
        $date = date('Y-m-d H:i:s');
        $code = "";
        try {
            $code = $this->uniqidReal(6);
        } catch (Exception $e) {
            //TODO: redirect to error page
        }
        
        $url = "date=" . $date . "code=" . $code . "email=" . $email;
        $url = $this->encryptText($url);

        return array('url' => $url, 'code' => $code, 'email' => $email, 'date' => $date );
    }

    function between($start, $end, $string) {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function after($start, $str) {
        if (!is_bool(strpos($str, $start)))
        return substr($str, strpos($str, $start)+strlen($start));
    }

    public function getDataFromUrlCode($url) {
        $url_decoded = $this->decryptText($url);

        $date = $this->between('date=', 'code=', $url_decoded);

        $code = $this->between('code=', "email=", $url_decoded);

        $email = $this->after('email=', $url_decoded);

        return array('date' => $date, 'code' => $code, 'email' => $email);
    }

    public function checkEmailDataBaseChanges($email) {
        //TODO: get t he email from databse and see if the estado changed recently.
        return true;
    }
}