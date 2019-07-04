<?php

require_once "config/router.php";

$router = new Router();
 
/* Add a Homepage route as a closure 
$router->add_route('/', function(){
    
});

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->execute($path);
*/
?>
<!DOCTYPE html>
    <head>
        <title>Remersas - Populetic</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <!-- Main CSS -->
        <link rel="stylesheet" href="web/css/main.css">

        <!-- Booststrap CSS -->
        <link rel="stylesheet" href="web/css/bootstrap.min.css">
    </head>
    
    <body>
        <div class="box-login d-flex justify-content-center">
            <form class="align-self-center text-center form-box" method="POST" action="controller/FormController.php">
                <img class="align-self-center" src="web/images/populetic.svg" alt="logo">
                <h1 class="h3 mb-3 font-weight-normal">Insert the amount of money</h1>
                <input type="number" id="amount" name="amount" class="form-control " value="" 
                    placeholder="Amount " autofocus="" required="" autocomplete="off">

                <div class="mt-4">
                    <input class="btn btn-lg btn-outline-info btn-block" type="submit" value="Send">
                </div><!-- closing div mt-4 -->

                <div class="mt-3 mb-3">
                    <p class="text-muted">Populetic © <?php echo date("Y"); ?></p>
                </div><!-- closing div mt-3 mb-3 -->
            </form>
        </div> <!-- closing div container -->

        <!-- Booststrap and jQuery JS -->
        <script  type="text/javascript" src="web/js/jquery-3.4.1.min.js"></script>
    </body>
</html>