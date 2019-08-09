<?php

session_start();

require_once dirname(__FILE__) . "/../../controller/Controller.php";

try {
    $hash = $_GET["hash"];

    if (!Controller::getinstance()->checkUrl($hash)) {
        unset($_SESSION['text']);
        $_SESSION['text'] = "Error validation your code!";
        echo $_SESSION['text'];
        header("Location: confirmation.php");
    }
} catch (Exception $e) {
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Populetic - Validate your Code </title>
        <?php include(dirname(__FILE__) . "/layouts/head.php") ?>
        
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>

    <body>

        <?php include( dirname(__FILE__) . "/layouts/header.php") ?>

        <div class="container code-form-container" id="box">
            <div class="card">
                <div class="card-header text-left">
                    <h5 class="mb-0">Verificación de Usuario</h5>
                </div><!-- closing div card-header text-left -->

                <div class="card-body">
                    <p class="text-left card-text">Inserte el código que ha recibido en su correo:</p>

                    <form method="POST" onsubmit="checkRecaptcha()" action="../../controller/ClientController.php">
                        <input type="hidden" name="hash" value="<?php echo $_GET['hash']; ?>">

                        <input type="text" class="form-control" maxlength="6" placeholder="Código de verificación. Ej: SH34DS"
                               name="code" onkeyup="this.value = this.value.toUpperCase();" value="" autofocus="" required=""
                               autocomplete="off">

                        <div class="mt-4 text-center">
                            <div class="g-recaptcha" data-sitekey="6LcnjRIUAAAAAKPYVfEL2M__Ix57s7zgQGVlCTux" ></div>
                        </div><!-- closing div mt-4 -->

                        <div class="form-group text-left">
                            <a href='emailForm.php?email= <?php echo $_SESSION['email'] . "&hash=" . $_SESSION['hash']; ?>'>
                                <span style="text-decoration: underline;">Informar de un problema (=enviar mail a admin)
                                </span>
                            </a>
                        </div><!-- closing div form-group text-left -->
                        <div class="form-group text-left">
                            <span>
                                <a href="#">
                                    Enviar el código de nuevo.
                                </a>
                            </span>
                        </div><!-- closing div form-group text-left -->
                        <div class="form-group">
                            <button class="btn btn-primary btn-block d-lg-flex flex-row-reverse justify-content-lg-center"
                                    id="btn-form-send" type="submit">
                                ENVIAR
                            </button>
                        </div><!-- closing div form-group -->
                    </form>
                </div><!-- closing div card-body -->
            </div><!-- clsoing div card -->
        </div><!-- clsoing div container code-form-container -->

        <?php include(dirname(__FILE__) . "/layouts/footer.php") ?>

        <?php include( dirname(__FILE__) . "/layouts/scripts.php") ?>
        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        <!-- <script type="text/javascript" src="../../web/js/emailValidation.js"></script>-->
        <script>
            function checkRecaptcha() {
                //TODO: change this interaction
                var recaptcha = $("#g-recaptcha-response").val();
                if (recaptcha === "") {
                    event.preventDefault();
                    alert('"Ups, Captcha no válido."');
                }
            }
        </script>
    </body>
</html>