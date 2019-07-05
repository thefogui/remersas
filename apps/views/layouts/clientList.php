<?php

session_start();

/**
 * This function generates a bootstrap table
 * @param $idName html id of the table
 * @param $thead an array that contains the data tu put in the head of the table
 * @param $data actual array that contains the data we want to put in the table
 */
function generateTable($idName = '', $thead = '', $data) {
    $content = "";
    $content .= '<table' . ($idName ? ' id="' . $idName . '"' : '') . ' class="table table-striped table-bordered" cellspacing="0" width="100%">';

    $content .= '<thead>';
    foreach ($thead as $cow) {
        $content .= '<tr>';
        $content .= $cow;
        $content .= '</tr>';
    }
    $content .= '</thead>';

    $content .= '<tbody>';

    foreach ($_SESSION['clientsVips'] as $key => $value) {
        $content .= $value;
    }

    $content .= '</tbody>';
    $content .= '</table>';

    return $content;
}

?>

<!DOCTYPE html>
    <head>
        <title>Remersas - Populetic</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <!-- Booststrap CSS -->
        <link rel="stylesheet" href="../../web/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

        <!-- Main CSS -->
        <link rel="stylesheet" href="../../web/css/main.css">
    </head>
    
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
                    <h1 class="h3 mb-3 font-weight-normal">
                        Amount of money left after pay vips: 
                        XXX€
                    </h1>
                </div>

                <div class="row">
                    <div class="card justify-content-center shadow p-3 mb-5 bg-white rounded" style="width: 80vw;">
                        <div class="card-body">
                            <h1>Clients Vips</h1>    
                            <?php echo generateTable("table") ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include("templates/scripts.php") ?>
        <!-- Main JS -->
        <script  type="text/javascript" src="../../web/js/main.js"></script>
    </body>
</html>