<?php
include("../../controller/Controller.php");

function getTable($idName, $destination, $thead = '') {
    $file = 'clientsvip';
    $string = file_get_contents($destination . $file . ".json", 'r');

    $data = json_decode($string, true); 
    
    session_start();
    $_SESSION['json_data_vclients'] = $data; //save the json data in the session so we can use it later to send emails

    if ($data) {
        try {
            #Controller::getInstance()->deleteJson($file, "../../cache/");
        } catch (Exception $e) {
            throw $e;
        }
        return generateTable($idName, $thead, $data);
    }

    return "There is no data to be showed";
}

/**
 * This function generates a bootstrap table
 * @param $idName html id of the table
 * @param $thead an array that contains the data to put in the head of the table
 * @param $data actual array that contains the data we want to put in the table
 */
function generateTable($idName = '', $thead = '', $data = array()) {
    $content = "";
    $content .= '<table' . ($idName ? ' id="' . $idName . '"' : '') . ' class="table table-striped table-bordered" cellspacing="0" width="100%">';

    $content .= '<thead>';
    $content .= '<tr>';
    foreach ($thead as $cow) {
        $content .= '<th>';
        $content .= $cow;
        $content .= '</th>';
    }
    $content .= '</tr>';
    $content .= '</thead>';

    $content .= '<tbody>';

    foreach ($data as $row) {
        $content .= '<tr>';
        foreach ($row as $cow) {
            $content .= '<td>';
            $content .= $cow;
            $content .= '</td>';
        }
        $content .= '</tr>';
    }
    $content .= '</tbody>';

    $content .= '</table>';

    return $content;
}

function sendEmails() {
    //TODO:: need to read the json and send email

    $_SESSION['json_data_vclients'];
    Controller::getInstance()->sendEmails();
}

if(array_key_exists('email-send', $_POST)) {
    sendEmails();
}

?>

<!DOCTYPE html>
    <?php include("layouts/header.php") ?>
    
    <body>
        <div class="d-flex justify-content-center" style="margim-top:3em!important;">
            <div class="container" style="margin-top: 2em;">
                <div class="row">
                    <img class="align-self-center" src="../../web/images/logo.png" alt="logo">
                </div>

                <div class="row">
                    <h1 class="h3 mb-3 font-weight-normal">
                        Amount of money inserted: 
                        <?php echo $_GET['amount'] ?>€ 
                    </h1>
                </div>

                <div class="row">
                    <?php
                        //Checks if the information is set in the session
                        if (isset($_POST["amountLeft"])) {
                            echo "<h1 class='h3 mb-3 font-weight-normal'>";
                            echo   "Amount of money left after pay vips:";
                            echo    $_POST["amountLeft"];
                            echo    "</h1>";
                        } else if ($_POST["amountToPaY"]) {
                            echo "<h1 class='h3 mb-3 font-weight-normal'>";
                            echo   "Amount of money to pay to clients vips:";
                            echo    $_POST["amountToPaY"];
                            echo    "</h1>";
                        }
                    ?>
                </div>

                <div class="row">
                    <div class="card justify-content-center shadow p-3 mb-5 bg-white rounded" style="width: 80vw;">
                        <div class="card-body">
                            <h1>Clients Vips</h1>    
                            <?php echo getTable("clientsVipsTable", "../../cache/", array("ID", "Nif", "Name", "Email")) ?>
                        </div>
                    </div>
                </div>

                <div class="send-email-div">
                <form method="post">
                    <input type="submit" name="email-send" id="email-send-button" value="Send Email to clients" />
                </form>
                </div><!-- Closing div send-email-div -->
            </div>
        </div>
        
        <?php include("layouts/scripts.php") ?>
        <!-- Main JS -->

        <script  type="text/javascript" src="../../web/js/main.js"></script>
    </body>
</html>