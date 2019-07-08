<?php

/**
 * This function verifies if the url that the used to get here is valid or not
 */

function checkUrl() {
    if (isset($_GET['email'])) {
        echo $_GET['email'];

        if (isset($_GET['hash'])) {
            echo $_GET['hash'];
        } else {
            // Fallback behaviour goes here
        }
    } else {
        // Fallback behaviour goes here
    }
}

checkUrl()

?>

<!DOCTYPE html>
    <?php include("layouts/header.php") ?>

    <body>
        <section>

        </section>

        <?php include("layouts/scripts.php") ?>
        <!-- Main JS -->
        <script  type="text/javascript" src="../../web/js/main.js"></script>
    </body>
</html>