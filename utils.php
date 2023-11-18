<?php

function checkNotEmptyParams(...$params){
    foreach ($params as $param) 
        if (empty($param)) {
            echo "<span>Devi compilare tutti i campi</span>";
            exit;
        }
}

function validateEmail($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<span>L'indirizzo email non è valido</span>";
        exit;
    }
}

function validatePassword($pass, $confirm){
    if($pass != $confirm){
        echo "<span>Le password non coincidono</span>";
        exit;
    }
}

function check_mysqliPrepareReturn($return, $con){
    if(!$return){
        error_log("Failed to prepare the query: ". mysqli_error($con), 3, "error.log");
        die("Something went wrong");
    }
}

function check_mysqliBindReturn($return, $con){
    if(!$return){
        error_log("Failed to bind the query: ". mysqli_error($con), 3, "error.log");
        die("Something went wrong");
    }
}

function check_mysqliExecuteReturn($return, $con){
    if(!$return){
        error_log("Failed to execute the query: ". mysqli_error($con), 3, "error.log");
        die("Something went wrong");
    }
}

function check_mysqliGetResultReturn($return, $con){
    if(!$return){
        error_log("Failed to get the result from the query: ". mysqli_error($con), 3, "error.log");
        die("Something went wrong");
    }
}

// Rimozione errori e warning da pagina utente
function errorHandler($errstr, $errfile, $errline) {
    echo "<span>Si è verificato un problema. Si prega di riprovare più tardi</span>";
    error_log("Errore o warning: $errstr in $errfile alla riga $errline", 3, "error.log");
}

// Per verificare la presenza di errori memorizzati nella sessione, ad esempio
// dalla precedente pagina di login
function checkSessionError(){
    if (isset($_SESSION['error_message'])) {
        echo "<span>" . $_SESSION['error_message'] . "</span>";
        unset($_SESSION['error_message']); 
    }
}

?>