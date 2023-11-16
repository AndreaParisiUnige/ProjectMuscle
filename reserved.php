<?php
session_start();
ob_start();
?>

<?php
require_once 'header.php';
require_once 'navbar.php';
?>


<?php
if (!isset($_SESSION["logged_in"])) {
    echo '<p>You must be logged in to access this page.</p>';
    header("Location: login.php");
    exit;
} else if ($_SESSION["logged_in"])
    echo '<h1 style="text-align: center;">Welcome to the reserved page!</h1>';
    echo '<p style="text-align: center;">Logged in as: ' . $_SESSION["email"] . '</p>';
require_once 'footer.php';
?>