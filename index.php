<?php

require_once "config/router.php";

// Add base route (startpage)
Router::getInstance()->add_route('/remesas/', function() {
    header("Location: apps/views/home.php");
});

Router::getInstance()->execute('/');