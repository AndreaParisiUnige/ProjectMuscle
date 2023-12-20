<?php
session_start();
ob_start();
require_once '../utility/query.php';

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    if (isset($_COOKIE["token"]) && isset($_SESSION["email"])) {
        $expiration = time() - (86400 * 30);
        setcookie("token", "deleted", $expiration, "/");

        try {
            update_UserData("users", ['rememberMeToken' => NULL, 'cookie_expiration' => NULL], "email=?", [$_SESSION["email"]], $con);
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Errore durante la fase di logout. Riprova più tardi.";
            error_log("Failed to logout user " . $_SESSION["email"] . ": " . $e->getMessage() . "\n", 3, "error.log");
        }
    }
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    session_destroy();
}
    
header("Location: ../structure/index.php");
exit();
?>
