<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Populetic - Remesas Welcome </title>
        <?php include(dirname(__FILE__) . "/layouts/head.php") ?>
    </head>
    
    
    <body>
        <div class="box-login d-flex justify-content-center">
            <img class="align-self-center load" src="../../web/images/loading.gif" alt="load">
            <form class="align-self-center text-center form-box" method="POST" onsubmit="showLoading()" action="../../controller/FormController.php">
                
                <img class="align-self-center" src="../../web/images/populetic.svg" alt="logo">
                <h1 class="h3 mb-3 font-weight-normal">Insert the amount of money</h1>
                <input type="number" id="amount" name="amount" class="form-control " value="" 
                    placeholder="Amount " autofocus="" required="" autocomplete="off">

                <div class="mt-4">
                    <input class="btn btn-lg btn-outline-info btn-block" type="submit" value="Send">
                </div><!-- closing div mt-4 -->
            </form>
        </div> <!-- closing div container -->

        <?php include(dirname(__FILE__) . "/layouts/footer.php") ?>

        <?php include("layouts/scripts.php") ?>
        <script>
            function showLoading() {
                $('.load').css('display','block');
                $('.form-box').css('display', 'none');
            }
        </script>
    </body>
</html>