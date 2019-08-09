<?php
include(dirname(__FILE__) . "/../../controller/Controller.php");

/**
 * Function to get the table data, reads a json file and print the table with values
 * @param $idName the table id
 * @param $source the json folder
 * @param string $thead the table head
 * @return string
 */
function getTable($idName, $source, $thead = '') {
    $file = 'clients';
    $string = file_get_contents($source . $file . ".json", 'r');

    $data = json_decode($string, true);
    
    $_SESSION['json_data_vclients'] = $data; //save the json data in the session so we can use it later to send emails

    if ($data)
        return generateTable($idName, $thead, $data, $_SESSION["numVips"]);
    return "There is no data to be showed";
}

/**
 * This function generates a bootstrap table
 * @param string $idName html id of the table
 * @param string $thead an array that contains the data to put in the head of the table
 * @param array $data actual array that contains the data we want to put in the table
 * @param int $numVips
 * @return string
 */
function generateTable($idName = '', $thead = array(), $data = array(), $numVips = 0) {
    $content = "";
    $index = 0;

    $content .= '<table' . ($idName ? ' id="' . $idName . '"' : '') . ' class="table table-striped table-bordered" cellspacing="0" 
                 width="100%">';
    $content .= '<thead class="thead-dark">';
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
        //TODO: https://codepen.io/cristinaconacel/pen/zmgmxE
        if (is_array($row) || is_object($row)) {
            foreach ($row as $cow) {
                if ($index < $numVips) {
                    $content .= '<td class="table-light">';
                    $content .= $cow;
                    $content .= '</td>';
                } else {
                    $content .= '<td class="table-secondary">';
                    $content .= $cow;
                    $content .= '</td>';
                }
            }
        }
        $content .= '</tr>';

        $index = $index + 1;
    }
    $content .= '</tbody>';

    $content .= '</table>';

    return $content;
}
/**
 * Function to send the emails to the clients
 */
function sendEmails() {
    Controller::getInstance()->sendEmails();
}

function checkAmountLeft() {
    //Checks if the information is set in the session
    $output = "";

    session_start();
    if (isset($_SESSION["amountLeft"])) {
        $output .= "<h1 class='h3 mb-3 font-weight-normal'>";
        $output .= "Amount of money left after pay vips: ";
        $output .= $_SESSION["amountLeft"];
        $output .= "</h1>";
    }

    return $output;
}

function checkAmountToPay() {
    //Checks if the information is set in the session
    $output = "";

    if (isset($_SESSION["amountToPay"])) {
        $output .= "<h1 class='h3 mb-3 font-weight-normal'>";
        $output .= "Amount of money to pay to clients vips: ";
        $output .= $_SESSION["amountToPay"];
        $output .= "</h1>";
    }

    return $output;
}

if(array_key_exists('email-send', $_POST))
    try {
        sendEmails();
    } catch (Exception $e) {
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="../../web/css/bootstrap.min.css">
        <title>Remesas - Populetic</title>
        <?php include( dirname(__FILE__) . "/layouts/head.php") ?>
    </head>
    
    <body>
        <div class="d-flex justify-content-center" style="margim-top:3em!important;">
            <div class="container" style="margin-top: 2em;">
                <div class="row">
                    <img class="align-self-center" src="../../web/images/logo.png" alt="logo">
                </div><!-- closing div row -->

                <div class="row">
                    <h1 class="h3 mb-3 font-weight-normal">
                        Amount of money inserted: 
                        <?php echo $_GET['amount'] ?>€ 
                    </h1>
                </div><!-- closing div row -->

                <div class="row">
                    <?php echo checkAmountLeft(); ?>
                </div><!-- closing div row -->

                <div class="row">
                    <?php echo checkAmountToPay(); ?>
                </div><!-- closing div row -->

                <div class="row">
                    <div class="card justify-content-center shadow p-3 mb-5 bg-white rounded" style="width: 80vw;">
                        <div class="card-body">
                            <h1>Clients</h1>

                            <div class="row text-center">
                                <img class="align-self-center mx-auto load" src="../../web/images/loading.gif">
                            </div><!-- closing div row -->
                            
                            <div class="table-responsive">
                                <?php
                                echo getTable("table", "../../cache/", array("Nif", "Name", "Email",
                                        "Compensation (€)", "Ref", "language", "Reclamación", "es vip?"));
                                ?>
                            </div><!-- closing div table-responsive -->
                        </div><!-- closing div card-body -->
                    </div><!-- closing div card justify-content-center shadow p-3 mb-5 bg-white rounded -->
                </div><!-- closing div row -->

                <div class="send-email-div">
                    <form method="post" action="../../controller/ClientListController.php" onsubmit="showLoading()">
                        <div class="w-25 p-3 center-block">
                            <input class="btn btn-lg btn-outline-info btn-block custom" type="submit" name="email-send"
                                   id="email-send-button" value="Send Email to clients">
                        </div><!-- closing div mt-4 -->
                    </form>
                </div><!-- closing div send-email-div -->
            </div><!-- closing div container -->
        </div><!-- closing div container d-flex justify-content-center -->
        
        <?php include("layouts/scripts.php") ?>

        <!-- Main JS -->
        <script type="text/javascript" src="../../web/js/main.js"></script>
        
        <script>
            function showLoading() {
                $('.load').css('display','block');
                $('.table-responsive').css('display', 'none');
            }
        </script>
    </body>
</html>