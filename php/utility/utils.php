<?php
//Gestione pagina
function redirectBack() {
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../structure/index.php'; 
    header("Location: $referer");
    exit();
}

function reloadPage() {
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

/*****************************************************************************************/

//Validazione dei dati
function checkNotEmptyParams(...$params){
    foreach ($params as $param) 
        if (empty($param)) {
            $_SESSION["error_message"] = "Errore: uno o più campi sono vuoti\n";
            redirectBack();
        }
}

function isSetAndNotEmpty($var) {
    return isset($var) && !empty($var);
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

/*****************************************************************************************/

//Gestione degli errori nelle query
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

// Errori di sessione
function checkSessionError(){
    if (isset($_SESSION['error_message'])) {
        echo "<div class='center-align' id='message'>" . $_SESSION['error_message'] . "</div>";
        unset($_SESSION['error_message']); 
    }
}
function checkSessionMessage(){
    if (isset($_SESSION['message'])) {
        echo "<div class='center-align' id='message'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']); 
    }
}

/*****************************************************************************************/
// Query
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

/*****************************************************************************************/
// Controlli login/admin, cookie e presenza id
function setSessionParams($row){
    $_SESSION["logged_in"] = true;
    $_SESSION["email"] = $row["email"];
    $_SESSION["admin"] = $row["admin"];  
}

function ifCookieSetSessionParams($con){
    if (isset($_COOKIE["token"])) {
        $select_Cookie = ['email', 'admin', 'rememberMeToken', 'cookie_expiration'];
        $where_stmt_Cookie = "rememberMeToken=? AND cookie_expiration > NOW()";
        if ($row = genericSelect("users", $select_Cookie, $where_stmt_Cookie, [$_COOKIE["token"]], $con))
            setSessionParams($row);
    }
}

function check_alreadyLoggedIn($con){
    ifCookieSetSessionParams($con);
    return (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]);
}

function check_admin($con){
    ifCookieSetSessionParams($con);
    return (isset($_SESSION["admin"]) && $_SESSION["admin"]);
}

function exitIfLogged ($con) {
    if (check_alreadyLoggedIn($con)) {
        header("Location: ../structure/index.php");
        exit;
    }
}

function exitIfNotLogged ($con) {
    if (!check_alreadyLoggedIn($con)) {
        header("Location: ../structure/index.php");
        exit;
    }
}

function exitIfNotAdmin ($con) {
    exitIfNotLogged ($con);
    if (!isset($_SESSION["admin"]) || !$_SESSION["admin"]) {
        header("Location: ../structure/index.php");
        exit;
    }
}

function requireId(){
    if (isset($_GET["id"]) && is_numeric($_GET["id"]))
        return $_GET["id"];
    else if (isset($_POST["id"]) && is_numeric($_POST["id"]))
        return $_POST["id"];
}


?>