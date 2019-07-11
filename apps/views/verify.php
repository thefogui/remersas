<?php

require_once "../../controller/VerifyController.php";
require_once "../../lib/model/dao/DaoUrlClient.php";

/**
 * This function verifies if the url that the used to get here is valid or not
 * @throws Exception if the email ins't a valid format
 */
function checkUrl() {

    $verifyController = new VerifyController();
    
    if (isset($_GET['email'])) {

        $email = $_GET['email']; //chekcs if the email insert in the url is a valid format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("The email inserted isn't a valid format.");
        }

        if (isset($_GET['hash'])) {
            //TODO: call the query with these parameters and redirect to the bank account form
            
            try {
                if ($verifyController->checkClientUrl($_GET['email'], $_GET['hash'])) {
                    //TODO: redirect to form
                    echo "here";
                    header("Location: bankAccountForm.php?email=" . $_GET['email'] . '&' . $_GET['hash']);
                } else {
                    //TODO: say it isn't a valid url
                    echo "Url inserted not valid!";
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        } else {
            // Fallback behaviour goes here
            //TODO: redirect or show error template
        }
    } else {
        // Fallback behaviour goes here
         //TODO: redirect or show error template
    }
}

try {
    checkUrl();
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


//TODO: Put load gif while this page is processed 
?>

<!DOCTYPE html>
    <?php include("layouts/header.php") ?>

    <body>
        <section>
            
        </section>

        <?php include("layouts/scripts.php") ?>
        <!-- Main JS -->
        <script  type="text/javascript" src="../../web/js/main.js"></script>
    </body>
</html>