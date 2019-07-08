<?php

require_once "../lib/model/entity/UrlClient.php";
require_once "../lib/model/dao/DaoUrlClient.php";

class ClientController {

    public function printAllVip() {
        $dao = new DaoClient();
        
    }

    /**
     * Function to send email to all clients saved in a json file
     */
    function sendEmailAll($file) {
        
    }

    /**
     * Function to send an email to an user
     */
    function send_email($info, $name, $email, $hash) {
         
        $to      = $email; // Send email to our user
        $subject = 'Signup | Verification'; // Give the email a subject 
        $message = '
     
        Hello from team Populetic, 
        Zombie ipsum reversus ab viral inferno' . $name . ', nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus brains sit​​, morbo vel maleficia? De apocalypsi gorger omero undead survivor dictum mauris. Hi mindless mortuis soulless creaturas, imo evil stalking monstra adventus resi dentevil vultus comedat cerebella viventium. Qui animated corpse, cricket bat max brucks terribilem incessu zomby.
     
        Please click this link to activate your account:
        http://www.yourwebsite.com/verify.php?email=' . $email.'&hash=' . $hash . '
        
        '; // Our message above including the link
                            
        $headers = 'From:noreply@populetic.com' . "\r\n"; // Set from headers
        mail($to, $subject, $message, $headers); // Send our email        
    }
}