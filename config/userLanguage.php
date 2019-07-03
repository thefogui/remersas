<?php
  session_start();

  include('conexion/conexion_translation.php');

  function getUserLanguage() {
  	$idioma = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : 'es';

       return $idioma;
  }
  
  $lang = getUserLanguage();
  
  $_SESSION['lang'] = isset($_SESSION['lang']) ? $_SESSION['lang'] : $lang;
?>