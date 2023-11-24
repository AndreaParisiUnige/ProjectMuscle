<?php

function redirectBack() {
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; 
    header("Location: $referer");
    exit();
}

function reloadPage() {
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

//Utils per la validazione dei dati
function checkNotEmptyParams(...$params){
    foreach ($params as $param) 
        if (empty($param)) {
            $_SESSION["error_message"] = "Errore: uno o più campi sono vuoti\n";
            redirectBack();
        }
}

function validateEmail($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error_message"] = "<span>L'indirizzo email non è valido</span>";
        redirectBack();
    }
}

function validatePassword($pass, $confirm){
    if($pass != $confirm){
        $_SESSION["error_message"] = "<span>Le password non coincidono</span>";
        redirectBack();
    }
}

//Utils per gestione degli errori nelle query
function check_mysqliPrepareReturn($return, $con){
    if(!$return){
        $_SESSION["error_message"] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi\n";
        error_log("Failed to prepare the query: ". mysqli_error($con) . "\n", 3, "error.log");
        redirectBack();
    }
}

function check_mysqliBindReturn($return, $con){
    if(!$return){
        $_SESSION["error_message"] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi\n";
        error_log("Failed to bind the query: ". mysqli_error($con) . "\n", 3, "error.log");
        redirectBack();
    }
}

function check_mysqliExecuteReturn($return, $con){
    if(!$return){
        $_SESSION["error_message"] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi\n";
        error_log("Failed to execute the query: ". mysqli_error($con) . "\n", 3, "error.log");
        redirectBack();
    }
}

function check_mysqliGetResultReturn($return, $con){
    if(!$return){
        $_SESSION["error_message"] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi\n";
        error_log("Failed to get the result from the query: ". mysqli_error($con) . "\n", 3, "error.log");
        redirectBack();
    }
}

// Rimozione errori e warning da vista utente
function errorHandler($errstr, $errfile, $errline) {
    $_SESSION["error_message"] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi\n";
    error_log("Errore o warning: $errstr in $errfile alla riga $errline\n", 3, "error.log");
    redirectBack();
}

// Per verificare la presenza di errori memorizzati nella sessione, ad esempio
// dalla precedente pagina di login
function checkSessionError(){
    if (isset($_SESSION['error_message'])) {
        echo "<span>" . $_SESSION['error_message'] . "</span>";
        unset($_SESSION['error_message']); 
    }
}
function checkSessionMessage(){
    if (isset($_SESSION['message'])) {
        echo "<span>" . $_SESSION['message'] . "</span>";
        unset($_SESSION['message']); 
    }
}

?>