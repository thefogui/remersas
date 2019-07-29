<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Populetic - Email request </title>
        <?php include( dirname(__FILE__) . "/layouts/head.php") ?>
    </head>

    <body>

        <?php include( dirname(__FILE__) . "/layouts/header.php") ?>

        <div class="container email-form-container" id="box">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-left mb-0">Confirmación de Email<br></h5>
                </div><!-- closing div card-header -->

                <div class="card-body">
                    <p class="text-left card-text">
                        Por favor, introduzca el correo electrónico&nbsp;&nbsp;
                        <strong>desde el que efectuó su reclamación:</strong>
                        <br>
                    </p>
                    <form method="POST" action="../../controller/emailFormController.php">
                        <input type="hidden" name="hash" value="<?php echo $_GET['hash']; ?>">
                        <div class="form-group">
                            <input class="form-control" type="email" style="" placeholder="Email" name="email" class="form-control " value="" autofocus="" required="" autocomplete="off">
                        </div><!-- closing div form-group -->

                        <p class="text-left">
                            <i class="icon ion-ios-information-outline"></i>  
                            Recibirá en este correo el código de verificación.&nbsp;
                            <br>
                        </p>

                        <div class="form-group">
                            <button class="btn btn-primary btn-block d-lg-flex flex-row-reverse justify-content-lg-center" id="btn-form-send" type="submit">
                                ENVIAR
                            </button>
                        </div><!-- closing div form-group -->
                    </form>
                </div><!-- closing div card-body -->
            </div><!-- closing div card -->
        </div><!-- closing div container email-form-container -->

        <?php include(dirname(__FILE__) . "/layouts/footer.php") ?>

        <?php include(dirname(__FILE__) . "/layouts/scripts.php") ?>
        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        <script type="text/javascript" src="../../web/js/emailValidation.js"></script>
    </body>
</html>