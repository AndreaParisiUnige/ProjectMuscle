<?php
require_once("../structure/header.php");
exitIfNotAdmin($con);

$id = requireId();
if (!$id){
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
