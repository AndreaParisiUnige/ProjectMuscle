<!--
L'accesso alla pagina è consentito solo agli utenti registrati e loggati.
E' possibile accedervi anche in presenza di un cookie di autenticazione valido.
Il controllo effettuato sul cookie di autenticazione trovato verifica l'esistenza e la scadenza dello stesso
In caso di cookie valido vengono settati i parametri di sessione che permetteranno l'accesso alla pagina.
-->

<?php
ob_start();
require_once 'header.php';
checkSessionError();
?>

<?php   
    if ((isset($_COOKIE["token"]) && genericSelect("users", SELECT_COOKIE, WHERE_STMT_COOKIE, [$_COOKIE["token"]], $con)) 
        || isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
        echo '<h1 style="text-align: center;">Welcome to the reserved page!</h1>';
        echo '<p style="text-align: center;">Logged in as: ' . $_SESSION["email"] . '</p>';
    } 
    else {
        echo '<p>You must be logged in to access this page.</p>';

        $accessDetails = [
            'timestamp' => date('d-m-Y H:i:s'),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        ];
        $accessDetailsJSON = json_encode($accessDetails);
        error_log("User tried to access reserved page without being logged in: $accessDetailsJSON\n", 3, "error.log");

        header("Location: login.php");
        exit;
    } 

require_once 'footer.php';
?>