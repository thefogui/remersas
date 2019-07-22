<!DOCTYPE html>
    <head>
        <title> Populetic - Email request </title>
        <?php include( dirname(__FILE__) . "/layouts/head.php") ?>
        <link rel="stylesheet" href="../../web/css/emailvalidation.css">
    </head>

    <body>
        <div class="box-login d-flex justify-content-center">
            <form class="align-self-center text-center form-box" method="POST" action="../../controller/emailFormController.php">
                <img class="align-self-center" src="../../web/images/populetic.svg" alt="logo">
                <p class="title">We gonna send the code to your email</p>
                <h1 class="h3 mb-3 font-weight-normal">Insert your email here:</h1>                <input type="email" placeholder="Email" name="email" class="form-control " value="" autofocus="" required="" autocomplete="off">

                <div class="mt-4">
                    <input class="btn btn-lg btn-outline-info btn-block" type="submit" value="Send">
                </div><!-- closing div mt-4 -->

                <div class="mt-3 mb-3">
                    <p class="text-muted">Populetic © <?php echo date("Y"); ?></p>
                </div><!-- closing div mt-3 mb-3 -->
            </form>
        </div> <!-- closing div container -->
        
        <!-- TODO: validate the form -->

        <?php include(dirname(__FILE__) . "/layouts/scripts.php") ?>
        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        <script type="text/javascript" src="../../web/js/emailValidation.js"></script>
    </body>
</html>