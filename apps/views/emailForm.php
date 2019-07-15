<!DOCTYPE html>
    <head>
        <?php include("layouts/header.php") ?>
        <link rel="stylesheet" href="../../web/css/emailvalidation.css">
    </head>
    <body>
        
        <h2 class="title">We gonna send the code to your email. Insert your email down here</h2>
        <!-- TODO: validate the form -->
        <form name="emailValidation" action="" method="POST" onsubmit="return validateForm()">
            <div class="input-group">
                <input class="input--style-3" type="email" placeholder="Email" name="email">
            </div>
            <div class="p-t-10">
                <button class="submit-btn btn btn-success btn--orange" type="submit">Submit</button>
            </div>
        </form>

        <?php include("layouts/scripts.php") ?>
        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        <script type="text/javascript" src="../../web/js/emailValidation.js"></script>

    </body>
</html>