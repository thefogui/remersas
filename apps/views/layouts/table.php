<?php

function build_table($array){
    // start table
    $html = '<table class="display table table-striped table-bordered" style="width:100%!important;">';
    // header row
    $html .= '<thead class="thead-dark">';
    $html .= '<tr><th>' . implode("</th><th>", array_keys($array[0])) . '</th></tr>';
    $html .= '</thead>';

    // data rows
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</table>';
    return $html;
}
echo build_table($data);
