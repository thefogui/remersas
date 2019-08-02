<?php 

require '../apps/views/View.php' ;

// Get template and assign vars
$template = new View('layouts/.php');

// Assign Vars
//$template->foo = "var";

echo $template;