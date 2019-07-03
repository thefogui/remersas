<?php

if(isset($_SERVER['SERVER_NAME'])){
  if($_SERVER['SERVER_NAME'] != 'localhost'){
    /* PRODUCTION SERVER */
  $servername = "production-database.cjytdcwzxu1j.us-east-2.rds.amazonaws.com";
  $username = "populetic";
  $password = "p0pprdfr0nt";
  $dbname = "halbrand";

  } else {
    /* LOCALHOST*/
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "halbrand";
  }
} else {

  if (substr(php_uname(), 0, 7) == "Windows"){
    /* LOCALHOST*/
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "halbrand";
  }else{
    /* SERVER */
  $servername = "production-database.cjytdcwzxu1j.us-east-2.rds.amazonaws.com";
  $username = "populetic";
  $password = "p0pprdfr0nt";
  $dbname = "halbrand";;
  }

}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
