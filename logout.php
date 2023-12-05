<?php
session_start();
ob_start();
?>

<?php
require_once 'connection.php';
require_once 'utils.php';
require_once 'query.php';

if (isset($_COOKIE["token"]) && isset($_SESSION["email"])) {
    $expiration = time() - (86400 * 30);
    setcookie("token", "deleted", $expiration, "/");

    try {
        manage_RememberMe($con, NULL , NULL , $_SESSION["email"]);
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Errore durante la fase di logout. Riprova più tardi.";
        error_log("Failed to logout user " . $_SESSION["email"] . ": " . $e->getMessage() . "\n", 3, "error.log");
    }
}
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}
session_destroy();
header("Location: index.php");
exit();
?>
