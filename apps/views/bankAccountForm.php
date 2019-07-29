<?php

session_start();

require_once dirname(__FILE__) . "/../../controller/Controller.php";
require_once "../../lib/model/dao/DaoClient.php";
require_once "../../lib/model/entity/Client.php";
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
    //TODO: PUt this in a controller
    $appConfig = new AppConfig();
    $conn = $appConfig->connect( "populetic_form", "replica" );
    $daoClient = new DaoClient();
    
    $hash = $_GET["hash"];

    if (isset($hash)) {
        $uncriptedHash = Controller::getInstance()->getDataFromUrlCode($hash);

        $date = $uncriptedHash["date"];
        $_SESSION["email"] = $uncriptedHash["email"];
        $email = $_SESSION["email"];
        $idReclamacion = $uncriptedHash["idReclamacion"];
        //TODO: get the reclamacion

        $reclamacion = $daoClient->getIdReclamacionById($conn, $idReclamacion);

        $appConfig->closeConnection($conn);

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
<html lang="en">
    <head>
        <title>Populetic - Bank Account Form</title>
        <?php include("layouts/head.php") ?>
        <link rel="stylesheet" href="../../web/css/bankAccountForm.css">
    </head>
    <body>

        <?php include( dirname(__FILE__) . "/layouts/header.php") ?>

        <div class="container" id="box">
            <div class="card" id="first">
                <div class="card-header">
                    <h5 class="text-left mb-0">Desglose de su reclamacion:</h5>
                </div>
                <div class="card-body" id="info">
                    <p class="card-text text-left">Nombre del pasajero:</p>
                    <p class="card-text text-left">Joan Pepito</p>
                    <p class="card-text text-left">Indenizacion</p>
                    <p class="card-text">xxx</p>
                    <p class="card-text text-left">Comision Populetic</p>
                    <p class="card-text">xxx</p>
                    <p class="card-text text-left">IVA</p>
                    <p class="card-text">xxx</p>
                    <p class="card-text text-left">Importe total a percibir</p>
                    <p class="card-text">xxx</p>
                </div>
            </div>
            <div class="card" id="second">
                <div class="card-header text-left">
                    <h5 class="mb-0">Datos Bancarios:</h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST" onsubmit="return validateForm()">
                        <div class="form-group">
                            <input class="form-control" type="text" name="IBAN" placeholder="IBAN" id="iban" size="35" required>
                        </div>

                        <input type="hidden" name="email" id="email" value="<?php echo $_SESSION["email"];?>" size="35" required>

                        <div class="text-left form-group">
                            <div class="form-check d-flex">
                                <input class="form-check-input" type="checkbox" id="formCheck-1">
                                <label class="form-check-label" for="formCheck-1">
                                    No dispongo de IBAN
                                </label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input class="form-control" type="text" name="address" placeholder="Direccion"  required="">
                            </div>
                            <div class="form-group col-md-6">
                                <input class="form-control" type="text" name="phone" placeholder="Telefono" autocomplete="off" autofocus="" inputmode="tel" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input class="form-control" type="text" name="titular" placeholder="Titular de la cuenta" style="height: 53px;min-height: 53px;min-width: 200px;" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <input class="form-control" type="text" name="email" placeholder="Email" style="height: 53px;min-height: 53px;min-width: 200px;" autocomplete="off" autofocus="" inputmode="email" required="">
                            </div>
                        </div>
                    </form>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block d-lg-flex flex-row-reverse justify-content-lg-center" id="btn-form-send"
                                type="submit">
                            ENVIAR
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php include(dirname(__FILE__) . "/layouts/footer.php") ?>

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