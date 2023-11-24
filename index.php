<?php
session_start();
ob_start();
?>

<?php
    require_once 'header.php';
    require_once 'navbar.php';
    checkSessionError();
    require_once 'main.php'; 
    require_once 'footer.php';
?>