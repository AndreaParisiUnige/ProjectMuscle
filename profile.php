<?php
    session_start();
    require_once 'header.php';
    require_once 'navbar.php';
    echo  $_SESSION["email"];
?>