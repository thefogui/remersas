<?php

session_start();

$text = $_SESSION['text'];

?>

<!DOCTYPE html>
    <?php include("layouts/header.php") ?>
    
    <body>
        <div class="box-login d-flex justify-content-center">  
            <div class="card shadow" style="width: 45rem; height: 30rem;">
                <div class="card-body align-self-center text-center">
                    <img class="align-self-center" src="../../web/images/populetic.svg" alt="logo">
                    <br>
                    <br>
                    <br>
                    <h5 class="card-title">
                        <?php echo $text ?>
                    </h5>
                    <div class="mt-3 mb-3">
                        <p class="text-muted">Populetic © <?php echo date("Y"); ?></p>
                    </div><!-- closing div card-title -->
                </div><!-- closing div card-body -->
            </div><!-- closing div container card -->
        </div> <!-- closing div justify-content-center -->

        <?php include("layouts/scripts.php") ?>
        <script>
            function showLoading() {
                $('.load').css('display','block');
                $('.form-box').css('display', 'none');
            }
        </script>
    </body>
</html>