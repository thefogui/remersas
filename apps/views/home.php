<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="../../web/css/bootstrap.min.css">
        <title> Populetic - Remesas Welcome </title>
        <?php include(dirname(__FILE__) . "/layouts/head.php") ?>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../web/css/dashboard.css">
    </head>
    
    <body>
        <nav id="nav">
            <div class="hamburguer-bt">
                <div class="hamburguer-bt__stripe hamburguer-bt__stripe__top"></div>
                <div class="hamburguer-bt__stripe hamburguer-bt__stripe__middle"></div>
                <div class="hamburguer-bt__stripe hamburguer-bt__stripe__bottom"></div>
            </div>
            
            <div class="content">
                <a href="#">Remesas</a>
                <a href="#">Facturas</a>
            </div>
        </nav>

        <section>
            <div class="card">
                <div class="card-header">
                    <img class="align-self-center" src="../../web/images/populetic.svg" alt="logo">
                </div>

                <div class="body">
                    <form method="POST" onsubmit="showLoading()" action="../../controller/FormController.php">
                        <h1>Insert the amount of money</h1>

                        <input type="number" id="amount" name="amount"  value="" 
                            placeholder="Amount " autofocus="" required="" autocomplete="off" min="40" max="15000">
                            
                        <input type="submit" class="align-self-center form-button" value="Send">
                        
                    </form>
                </div>

                <div class="text-right d-flex justify-content-end footer">
                    <p>© Populetic 2019</p>
                </div>
            </div>
        </section>

        <div class="box-login d-flex justify-content-center">
            <img class="align-self-center load" src="../../web/images/loading.gif" alt="load">
            
        </div> <!-- closing div container -->

        <?php /*include(dirname(__FILE__) . "/layouts/footer.php")*/ ?>

        <?php include("layouts/scripts.php") ?>
        <script>
            $(".content").css("display", "none");
            $("nav").css('width', "auto");

            $(document).ready(function() {
                $(".hamburguer-bt").click(function() {
                    if ($(this).hasClass("on")) {
                        $(this).removeClass("on");
                        $(".content").css("display", "none");
                        $("nav").css('width', "auto");
                    } else {
                        $(this).toggleClass("on");
                        $(".content").css("display", "block");
                        $("nav").css('width', "10vw");
                    }
                    
                });
            });

            function showLoading() {
                $('.load').css('display','block');
                $('.form-box').css('display', 'none');
                
            }
        </script>
    </body>
</html>