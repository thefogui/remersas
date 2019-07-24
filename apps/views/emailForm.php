<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Populetic - Email request </title>
        <?php include( dirname(__FILE__) . "/layouts/head.php") ?>
        <link rel="stylesheet" href="../../web/css/emailvalidation.css">
    </head>

    <body>
        <div class="box d-flex justify-content-center">
            <form class="align-self-center text-center form-box" method="POST" action="../../controller/emailFormController.php">
                <img class="align-self-center" src="../../web/images/populetic.svg" alt="logo">
                <h1 class="h3 mb-3 font-weight-normal">Por favor, introduzca el correo electrónico desde el que efectuó su reclamación:</h1>
                
                <input type="hidden" name="hash" value="<?php echo $_GET['hash']; ?>">
                
                <input type="email" placeholder="Email" name="email" class="form-control " value="" autofocus="" required="" autocomplete="off">

                <div class="mt-4">
                    <input class="btn btn-lg btn-outline-info btn-block" type="submit" value="ENVIAR">
                </div><!-- closing div mt-4 -->

                <p>Recibirá en este correo el código de verificación.</p>

                
            </form>
        </div> <!-- closing div container -->
        
        <!-- TODO: validate the form -->

        <?php include(dirname(__FILE__) . "/layouts/footer.php") ?>

        <?php include(dirname(__FILE__) . "/layouts/scripts.php") ?>
        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        <script type="text/javascript" src="../../web/js/emailValidation.js"></script>
    </body>
</html>