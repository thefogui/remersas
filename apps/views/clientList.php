<?php
include("../../controller/Controller.php");

function getTable($idName, $destination, $thead = '') {
    $file = 'clientsvip';
    $string = file_get_contents($destination . $file . ".json", 'r');

    $data = json_decode($string, true);
   
    try {
        Controller::getInstance()->deleteJson($file, "../../cache/");
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }    
    return generateTable($idName, $thead, $data);
}

/**
 * This function generates a bootstrap table
 * @param $idName html id of the table
 * @param $thead an array that contains the data to put in the head of the table
 * @param $data actual array that contains the data we want to put in the table
 */
function generateTable($idName = '', $thead = '', $data) {
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
                    <h1 class="h3 mb-3 font-weight-normal">
                        Amount of money left after pay vips: 
                        XXX€
                    </h1>
                </div>

                <div class="row">
                    <div class="card justify-content-center shadow p-3 mb-5 bg-white rounded" style="width: 80vw;">
                        <div class="card-body">
                            <h1>Clients Vips</h1>    
                            <?php echo getTable("clientsVipsTable", "../../cache/", array("ID", "Nif", "Name", "Email")) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include("layouts/scripts.php") ?>
        <!-- Main JS -->
        <script  type="text/javascript" src="../../web/js/main.js"></script>
    </body>
</html>