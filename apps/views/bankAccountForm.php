<?php

?>

<!DOCTYPE html>
    <?php include("layouts/header.php") ?>

    <body>
        <section>
            <form name="bankAccountForm" action="" method="POST" onsubmit="return validateForm()">
                <input type="text" name="bank-account-number" id="bank-account-number" placeholder="Bank account number" size="35" required>
                <input type="text" id="bank-account-titular" name="bank-account-titular" placeholder="Bank Account Titular" size="75" required>
                <input type="text" id="bank-account-address" name="bank-account-address" placeholder="invoice address" size="75" required>
                <input type="submit" id="bank-accout">
            </form>
        </section>

        <?php include("layouts/scripts.php") ?>
        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        <script type="text/javascript" src="../../web/js/bankAccountForm.js"></script>

    </body>
</html>