<?php
?>
<!DOCTYPE html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <!-- Main CSS -->
        <link rel="stylesheet" href="web/css/main.css">

        <!-- Booststrap CSS -->
        <link rel="stylesheet" href="web/css/bootstrap.min.css">
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12 align-self-center logo">
                    <img class="align-self-center" src="web/images/logo.png" alt="logo">
                </div><!-- closing div col-12 align-self-center logo -->
            </div> <!-- closing div row -->

            <div class="row">
                <div class="col-12 form_div">

                    <h1 class="h3 mb-3 font-weight-normal">Insert the amount of money</h1>

                    <form class="align-self-center" method="" action="">
                        <input type="text" id="amount" name="amount" class="form-control " value="" 
                            placeholder="Amount " autofocus="" required="" autocomplete="off">

                            <div class="mt-4">
                                <input class="btn btn-lg btn-outline-info btn-block" type="submit" value="Send">
                            </div><!-- closing div mt-4 -->
                    </form>
                </div><!-- closing div col-12 form_div -->
            </div> <!-- closing div row -->

            <div class="mt-3 mb-3">
                <p class="text-muted">Populetic © 2019</p>
            </div><!-- closing div mt-3 mb-3 -->

        </div> <!-- closing div container -->



        <!-- Booststrap and jQuery JS -->
        <script  type="text/javascript" src="web/js/jquery-3.4.1.min.js"></script>
    </body>
</html>