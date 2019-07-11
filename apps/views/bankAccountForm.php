<?php

?>

<!DOCTYPE html>
    <head>
        <?php include("layouts/header.php") ?>
        <link rel="stylesheet" href="../../web/css/bankAccountForm.css">
    </head>
    <body>
        <div class="page-wrapper bg-gra-01 p-t-180 p-b-100 font-poppins">
            <div class="wrapper wrapper--w780">
                <div class="card card-3">
                    <div class="card-heading"></div>
                    <div class="card-body">
                        <h2 class="title">Insert your account information below</h2>
                        <form name="bankAccountForm" action="" method="POST" onsubmit="return validateForm()">
                            <div class="input-group">
                                <input class="input--style-3" type="text" name="bank-account-number" id="bank-account-number" placeholder="Bank account number" size="35" required>
                            </div>
                            <div class="input-group">
                                <input class="input--style-3" type="text" id="bank-account-titular" name="bank-account-titular" placeholder="Bank Account Titular" size="75" required>
                            </div>
                            <div class="input-group">
                                <input class="input--style-3" type="text" id="bank-account-address" name="bank-account-address" placeholder="invoice address" size="75" required>
                            </div>
                            <div class="input-group">
                                <input class="input--style-3" type="email" placeholder="Email" name="email">
                            </div>
                            <div class="input-group">
                                <input class="input--style-3" type="text" placeholder="Phone" name="phone">
                            </div>
                            <div class="p-t-10">
                                <button class="submit-btn btn btn-success btn--orange" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include("layouts/scripts.php") ?>
        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        <script type="text/javascript" src="../../web/js/bankAccountForm.js"></script>

    </body>
</html>