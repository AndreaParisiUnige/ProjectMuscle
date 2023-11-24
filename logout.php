<?php
session_start();
ob_start();
?>

<?php
require_once 'connection.php';
require_once 'utils.php';
require_once 'query.php';
set_error_handler("errorHandler");


if (isset($_COOKIE["token"])) {
    $expiration = time() - (86400 * 30);
    setcookie("token", "deleted", $expiration, "/");

    try {
        remove_RememberMe($con);
    } catch (Exception $e) {
        $_SESSION['error_message'] = "<span>Something went wrong</span>";
        error_log("Failed to logout user: " . $e->getMessage() . "\n", 3, "error.log");
    }
}
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}
session_destroy();
header("Location: index.php");
exit();
?>
