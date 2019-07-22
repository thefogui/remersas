<?php

session_start();

require_once dirname(__FILE__) . "/../../controller/Controller.php";
require_once dirname(__FILE__) . "/../../controller/BankAccountController.php";


/***
 * TODO: Pass this function to the controller
 */
/**
 * Function to the check the url 
 * get the key and value and check is the values aren't expired
 */
function checkUrl() {
    if (!isset($_GET["hash"])) return false;

    $hash = $_GET["hash"];

    if ($hash) {
        $uncriptedHash = Controller::getInstance()->getDataFromUrlCode($hash);
        $date = $uncriptedHash["date"];
        $_SESSION["email"] = $uncriptedHash["email"];
        $email = $_SESSION["email"];

        if (Controller::getInstance()->checkExpiredOneDay($date)){
            // Fallback behaviour goes here
            return false;
        } else 
            return Controller::getInstance()->checkEmailDataBaseChanges($email);
    } else {
        // Fallback behaviour goes here 
        return false;
    }
    return false;
}

try {
    if (!checkUrl()) {
        unset ($_SESSION['text']);
        $_SESSION['text'] = "Error validation your code!";
        header("Location: confirmation.php");
    }
} catch (Exception $e) {
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
    $bankAccoubtController = new BankAccountController();
    

?>

<!DOCTYPE html>
    <head>
        <title>Populetic - Bank Account Form</title>
        <?php include("layouts/head.php") ?>
        <link rel="stylesheet" href="../../web/css/bankAccountForm.css">
    </head>
    <body>
        <div class="page-wrapper bg-gra-01 p-t-180 p-b-100 font-poppins">
            <div class="wrapper wrapper--w780">
                <div class="card card-3">
                    <div class="card-heading"></div>
                    <div class="card-body">
                        <h2 class="title">Insert your account information below</h2>
                        <!-- TODO: create a form controller -->

                        <form name="bankAccountForm" action="" method="POST" onsubmit="return validateForm()">
                        <div class="input-group">
                                <input class="input--style-3 iban" type="hidden" name="email" id="email" value="<?php echo $_SESSION["email"];?>" size="35" required>
                            </div>
                            
                            <div class="input-group">
                                <input class="input--style-3 iban" type="text" name="iban" id="iban" placeholder="IBAN" size="35" required>
                            </div>

                            <div class="input-group">
                                <input class="form-check-input chk-iban" type="checkbox" id="iban-checkbox">
                                <label class="form-check-label" for="iban-checkbox">
                                    I don't have it.
                                </label>
                            </div>

                            <div class="input-group">
                                <input class="input--style-3" type="text" id="bank-account-titular" name="bank-account-titular" placeholder="Bank Account Titular" size="75" required>
                            </div>
                            <div class="input-group">
                                <input class="input--style-3" type="text" id="bank-account-address" name="bank-account-address" placeholder="invoice address" size="75" required>
                            </div>
                            <div class="input-group">
                                <input class="input--style-3" type="email" placeholder="Email" name="email">
                            </div>
                            <div class="input-group">
                                <input class="input--style-3" type="text" placeholder="Phone" name="phone">
                            </div>
                            <div class="p-t-10">
                                <button class="submit-btn btn btn-success btn--orange" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include("layouts/scripts.php") ?>
        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        <script type="text/javascript" src="../../web/js/bankAccountForm.js"></script>
        <script>
            $('.chk-iban').change(function() {
                if(this.checked) {
                    //Do stuff
                    $( "#iban" ).removeClass( "iban" );
                    $( "#iban" ).attr('placeholder','Bank account number');
                    $( "#iban" ).attr('name','bank-account-number');
                } else {
                    $( "#iban" ).addClass( "iban" );
                    $( "#iban" ).attr('placeholder','IBAN');
                    $( "#iban" ).attr('name','iban');
                }
            });
        </script>
    </body>
</html>