<?php

session_start();
require_once dirname(__FILE__) . "/../../controller/Controller.php";
require_once dirname(__FILE__) . "/../../controller/BankAccountController.php";

try {
    $hash = $_GET["hash"];

    if (!Controller::getInstance()->checkUrlbankAccountView($hash)) {
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
    </head>
    <body>
        <?php include( dirname(__FILE__) . "/layouts/header.php") ?>

        <div class="container" id="box">
            <div class="row">
                <div class="card col-sm-4" id="first">
                    <div class="card-header">
                        <h5 class="text-left mb-0">Desglose de su reclamacion:</h5>
                    </div><!-- closing div card-header -->

                    <div class="card-body" id="info">
                        <p class="card-text text-left">Nombre del pasajero:</p>
                        <p class="card-text text-left"><?php echo $_SESSION["reclamacion"]['name'] ?></p>
                        <p class="card-text text-left">Indenizacion</p>
                        <p class="card-text">xxx</p>
                        <p class="card-text text-left">Comision Populetic</p>
                        <p class="card-text">xxx</p>
                        <p class="card-text text-left">IVA</p>
                        <p class="card-text">xxx</p>
                        <p class="card-text text-left">Importe total a percibir</p>
                        <p id="amount"><?php echo $_SESSION["reclamacion"]['compensation'] ?>€</p>
                    </div><!-- closing div card-body -->
                </div><!-- closing card col-sm-4 -->
                <div class="card col-sm fix-width" id="second">
                    <div class="card-header text-left">
                        <h5 class="mb-0">Datos Bancarios:</h5>
                    </div><!-- closing div card-header -->
                    <div class="card-body">
                        <form action="" method="POST" onsubmit="return validateForm()">
                            <div class="form-group">
                                <input class="form-control iban bank-account-number" type="text" name="IBAN" placeholder="IBAN" id="iban" size="35" required>
                            </div><!-- clsoing div form-group -->

                            <input type="hidden" name="email" id="email" value="<?php echo $_SESSION["email"];?>" size="35">

                            <div class="form-row">
                                <div class="form-group col-md-6 my-auto">
                                    <div class="form-check d-flex">
                                        <input class="form-check-input chk-iban" type="checkbox" id="formCheck-1">
                                        <label class="form-check-label" for="formCheck-1">
                                            No dispongo de IBAN
                                        </label>
                                    </div><!-- closing div form-check d-flex -->
                                </div><!-- closing div form-group col-md-6 my-auto -->
                                <div class="form-group col-md-6">
                                    <input class="form-control"  style="visibility:hidden;" type="text" placeholder="swift" name="swift" id="swift" value="" size="35">
                                </div><!-- closing div form-group col-md-6  -->
                            </div><!-- closing div form-row -->

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input class="form-control" type="text" name="address" placeholder="Direccion"  required="">
                                </div><!-- closing div form-group col-md-6  -->
                                <div class="form-group col-md-6">
                                    <input class="form-control" type="text" name="phone" placeholder="Telefono" autocomplete="off" autofocus="" inputmode="tel" required="">
                                </div><!-- closing div form-group col-md-6  -->
                            </div><!-- closing div form-row -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input class="form-control" type="text" name="titular" placeholder="Titular de la cuenta" style="height: 53px;min-height: 53px;min-width: 200px;" required="">
                                </div><!-- closing div form-group col-md-6  -->
                                <div class="form-group col-md-6">
                                    <input class="form-control" value="<?php echo $_SESSION["email"];?>" type="text" name="email" placeholder="Email" style="height: 53px;min-height: 53px;min-width: 200px;" autocomplete="off" autofocus="" inputmode="email" required="">
                                </div><!-- closing div form-group col-md-6  -->
                            </div><!-- closing div form-row -->

                            <div class="form-group">
                                <p class="text-left color-green">
                                    <i class="icon ion-ios-information-outline"></i>  
                                    Si has recibido más de un email de este tipo, debes poner los datos bancarios en todos los emails recibidos. &nbsp;
                                    <br>
                                </p>
                            </div><!-- closing div form-group -->

                            <div class="form-group">
                                <button class="btn btn-primary btn-block d-lg-flex flex-row-reverse justify-content-lg-center" id="btn-form-send"
                                        type="submit">
                                    ENVIAR
                                </button>
                            </div><!-- closing div form-group -->
                        </form>
                    </div><!-- closing div card-body-->
                </div><!-- closing div card -->
            </div><!-- closing div row -->
        </div><!-- closing div container -->

        <?php include(dirname(__FILE__) . "/layouts/footer.php") ?>

        <?php include("layouts/scripts.php") ?>
        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        <script type="text/javascript" src="../../web/js/bankAccountForm.js"></script>
        <script>
            $('.chk-iban').change(function() {
                if(this.checked) {
                    //if the client mark the checkbox this remove the iban class
                    $( "#iban" ).removeClass( "iban" );
                    $( "#iban" ).attr('placeholder','Bank account number');
                    $( "#iban" ).attr('name','bank-account-number');
                    $("#swift").css('visibility', 'visible');
                    $("#swift").attr("required", true);
                } else {
                    $( "#iban" ).addClass( "iban" );
                    $( "#iban" ).attr('placeholder','IBAN');
                    $( "#iban" ).attr('name','iban');
                    $("#swift").css('visibility', 'hidden');
                }
            });
        </script>
    </body>
</html>