<?php
require 'View.php' ;
include(dirname(__FILE__) . "/../../controller/Controller.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Populetic - Remesas Welcome </title>
        <?php include(dirname(__FILE__) . "/layouts/head.php") ?>
        <link rel="stylesheet" href="../../web/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../web/css/dashboard.css">
    </head>
    
    <body>
        <?php
            $nav = new View('/layouts/nav.php');
            echo $nav;
        ?>

        <section>
            <div class="card" id="home">
                <h1 class="title">Welcome</h1>
                <hr id="asterisk" data-content="*">
            </div><!-- closing div table -->

            <div class="card" id="form">
                <div class="card-header">
                    <img class="" src="../../web/images/populetic.svg" alt="logo">
                </div><!-- closing div card-header -->

                <div class="body">
                    <form method="POST" onsubmit="showLoading()" action="../../controller/FormController.php">
                        <h1>Insert the amount of money</h1>

                        <label>
                            <input type="number" name="amount" value=""
                                   autofocus="off" required="" autocomplete="off" min="40" max="15000">
                            <div class="label-txt">Amount</div>
                        </label>

                        <input type="submit" class="align-self-center form-button" value="Send">
                    </form>
                </div><!-- closing div body -->

                <div class="text-right d-flex justify-content-end footer">
                    <p class="p-footer">© Populetic <?= date("Y"); ?></p>
                </div><!-- closing div text-right d-flex justify-content-end footer -->
            </div><!-- closing div card -->

            <div class="card table-content" id="table">

            </div><!-- closing div table -->

            <div class="card table-content" id="accounts">
                <?php
                $template = new View('/layouts/table.php');
                $template->data = Controller::getInstance()->getBankAccountData();
                echo $template;
                ?>
            </div><!-- closing div table -->
        </section>

        <div class="box-login d-flex justify-content-center">
            <img class="align-self-center load" src="../../web/images/loading.gif" alt="load">
        </div> <!-- closing div container -->

        <?php include("layouts/scripts.php") ?>
        <script src="../../web/js/nav.js"></script>
        <script src="../../web/js/main.js"></script>

        <script>
            function showLoading() {
                $('.load').css('display', 'block');
                $('section').css('display', 'none');
            }
        </script>
    </body>
</html>