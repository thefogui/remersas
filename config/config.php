<?php

if(!$_SERVER['SERVER_ADDR'] == '127.0.0.1'){
  /* PRODUCTION SERVER */
  $hotsdb = "127.0.0.1";
  $basededatos = "populetic_form";
  $usuariodb = "popprdfront";
  $clavedb = "p0pprdfr0nt";



} else {
  /* LOCALHOST*/
  $hotsdb = "127.0.0.1";
  $basededatos = "populetic_form";
  $usuariodb = "root";
  $clavedb = "";
}

$conexion_db = mysql_connect("$hotsdb","$usuariodb","$clavedb")
    or die ("Conexión denegada, el Servidor de Base de datos que solicitas NO EXISTE");
    $db = mysql_select_db("$basededatos", $conexion_db)
    or die ("La Base de Datos <b>$basededatos</b> NO EXISTE");
?>
