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
        $_SESSION["error_message"] = "L'indirizzo email non è valido";
        redirectBack();
    }
}

function validatePassword($pass, $confirm){
    if($pass != $confirm){
        $_SESSION["error_message"] = "Le password non coincidono";
        redirectBack();
    }
}

//Utils per gestione degli errori nelle query
function check_mysqliFunction($return, $con, $fun, $query){
    if(!$return){
        if (mysqli_errno($con) === 1062)
			$_SESSION['error_message'] = "Errore:account già registrato";
        else
            $_SESSION["error_message"] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi\n";
        $errorMessage = "Failed to complete the function '" . $fun ."'";
        if (!empty($query)) {
            $errorMessage .= " (Query: " . $query . ")";
        }
        $errorMessage .= ": " . mysqli_error($con) . "\n";
        error_log($errorMessage, 3, "error.log");
        redirectBack();
    }
}

// Rimozione errori e warning da vista utente
function errorHandler($errno, $errstr, $errfile, $errline) {
    $_SESSION["error_message"] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi\n";
    error_log("Errore o warning: $errstr in $errfile alla riga $errline\n", 3, "error.log");
    redirectBack();
}

// Per verificare la presenza di errori memorizzati nella sessione, ad esempio
// dalla precedente pagina di login
function checkSessionError(){
    if (isset($_SESSION['error_message'])) {
        echo "<div class='center-align'>" . $_SESSION['error_message'] . "</div>";
        unset($_SESSION['error_message']); 
    }
}
function checkSessionMessage(){
    if (isset($_SESSION['message'])) {
        echo "<div class='center-align'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']); 
    }
}

function getTypes($valori){
    $tipi = '';
    foreach ($valori as $valore) {
        if (is_int($valore)) {
            $tipi .= 'i'; // Interi
        } elseif (is_float($valore)) {
            $tipi .= 'd'; // Double/float
        } elseif (is_bool($valore)) {
            $tipi .= 'i'; // Booleani possono essere trattati come interi
        } else {
            $tipi .= 's'; // Default a stringa per altri tipi
        }
    }
    return $tipi;
}

function setSessionParams($row){
    $_SESSION["logged_in"] = true;
    $_SESSION["email"] = $row["email"];
    $_SESSION["admin"] = $row["admin"];  
}

?>