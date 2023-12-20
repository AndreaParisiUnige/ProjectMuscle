<?php
require_once("../structure/header.php");
exitIfNotAdmin($con);

if (isset($_GET["id"]) && is_numeric($_GET["id"]))
    $id = $_GET["id"];
else if (isset($_POST["id"]) && is_numeric($_POST["id"]))
    $id = $_POST["id"];
else {
    header("Location: ../user/allusers.php");
    exit;
}
try {
    if (delete_user($id, $con))
        $_SESSION['message'] = 'Utente eliminato con successo';
} catch (Exception $e) {
    $_SESSION['error_message'] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi";
    error_log("Failed to delete " . ($id) . " data from the database: " . $e->getMessage() . "\n", 3, "error.log");
}
header("Location: ../user/allusers.php");
exit;
