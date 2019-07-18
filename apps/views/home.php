<!DOCTYPE html>
    <?php include(dirname(__FILE__) . "/layouts/header.php") ?>
    
    <body>
        <!-- TODO: loading gif -->
        <div class="box-login d-flex justify-content-center">
            <img class="align-self-center load" src="../../web/images/loading.gif">
            <form class="align-self-center text-center form-box" method="POST" onsubmit="showLoading()" action="../../controller/FormController.php">
                
                <img class="align-self-center" src="../../web/images/populetic.svg" alt="logo">
                <h1 class="h3 mb-3 font-weight-normal">_(msgEjemplo.1) 2550€ _(msgEjemplo.2)</h1>
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

        <?php include("layouts/scripts.php") ?>
        <script>
            function showLoading() {
                $('.load').css('display','block');
                $('.form-box').css('display', 'none');
            }
        </script>
    </body>
</html>