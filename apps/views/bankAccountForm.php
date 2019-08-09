<?php
require_once dirname(__FILE__) . "/../../controller/Controller.php";
require_once dirname(__FILE__) . "/../../controller/BankAccountController.php";
require 'View.php' ;

session_start();

try {
    $hash = $_GET["hash"];

    if (!Controller::getInstance()->checkUrlbankAccountView($hash)) {
        unset ($_SESSION['text']);
        $_SESSION['text'] = 'Error validation your code!';
        header('Location: confirmation.php');
    }
} catch (Exception $e) {
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bankAccountController = new BankAccountController();
    $bankAccountController->insertDataIntoBankAccountDataBase();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Populetic - Bank Account Form</title>
        <?php include("layouts/head.php") ?>
    </head>

    <body>
        <?php include( dirname(__FILE__) . "/layouts/header.php") ?>

        <?php
            
            foreach ($_SESSION['claims'] as $claim) {
                $template = new View('/layouts/formBankAccount.php');

                $template->name = $claim['name'];
                $template->email = $claim['email'];
                $template->compensation = $claim['compensation'];
                $template->clientAmount = $claim['clientAmount'];
                $template->comision = $claim['comision'];

                echo $template;
            }
        ?>

        <?php include(dirname(__FILE__) . "/layouts/footer.php") ?>

        <?php include("layouts/scripts.php") ?>
        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        <script type="text/javascript" src="../../web/js/bankAccountForm.js"></script>
        <script type="text/javascript">
            $('.chk-iban').change(function() {
                var ibanInput =  $("#iban");

                if(this.checked) {
                    //if the client mark the checkbox this remove the iban class
                    ibanInput.removeClass( "iban" );
                    ibanInput.attr('placeholder','Bank account number');
                    $("#swift").css('visibility', 'visible');
                    $("#swift").attr("required", true);
                } else {
                    ibanInput.addClass( "iban" );
                    ibanInput.attr('placeholder','IBAN');
                    $("#swift").css('visibility', 'hidden');
                    $("#swift").attr("required", false);
                }
            });
        </script>
    </body>
</html>