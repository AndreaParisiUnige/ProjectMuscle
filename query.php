<?php
/*  La logica di controllo degli errori applicata è la seguente: se falliscono funzioni
    il cui motivo di fallimento è noto (es. tentativo di inserire un utente già esistente)
    viene stampato un messaggio di errore specifico all'utente. 
    Se invece fallisce una funzione il cui motivo di fallimento non è noto, viene memorizzato
    su un file di log l'errore e si invia all'utente un messaggio d'errore generico.
*/
require_once 'utils.php';
set_error_handler("errorHandler");

define('SELECT_PARAMS', ['email', 'admin', 'rememberMeToken', 'cookie_expiration']);
define('WHERE_STMT', 'rememberMeToken=? AND cookie_expiration > NOW()');


// Richiede la tabella su cui fare la query, divide un array in stringhe separate da virgola e le concatena
// per comporre la select. Richiede una stringa per comporre il where e un array con i tipi di dato da inserire
// Il primo array può essere un regolare array, il secondo deve essere un array associativo

function genericSelect($table, $select_Columns, $where, $toBind, $con){
    $query = "SELECT " . implode(", ", $select_Columns) . " FROM " . $table . " WHERE " . $where;
    check_mysqliFunction($stmt = mysqli_prepare($con, $query), $con, 'prepare', $query);

    if (!empty($toBind)) {
        $values = array_values($toBind);    // Ottengo i nomi associati ai valori sotto forma di array
        $types = getTypes($values);         // Ottengo i tipi di dato associati ai valori sotto forma di stringa
        check_mysqliFunction(mysqli_stmt_bind_param($stmt, $types, ...$values), $con, 'bind', $query);
    }

    check_mysqliFunction(mysqli_stmt_execute($stmt), $con, 'bind', $query);
    check_mysqliFunction($result = mysqli_stmt_get_result($stmt), $con, 'get result', $query);
    mysqli_stmt_close($stmt);
    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);      
        return $row;
    }
    return null;
}

//CHECKED
function insert_user_data($name, $lastname, $email, $hash, $con){

    $insert_stmt = mysqli_prepare($con, "INSERT INTO users (id, nome, cognome, email, password, registration_date, admin)
                                VALUES (NULL, ?, ?, ?, ?, NULL, 0)");

    check_mysqliPrepareReturn($insert_stmt, $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($insert_stmt, "ssss", $name, $lastname, $email, $hash), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($insert_stmt), $con);

    if (mysqli_stmt_affected_rows($insert_stmt)) {
        mysqli_stmt_close($insert_stmt);
        return true;   
    }
    else {
        error_log("Failed to insert the user" .$email. " into the database: ". mysqli_error($con) ."\n", 3, "error.log");   
        mysqli_stmt_close($insert_stmt);
        return false;
    }
}

function delete_user($id, $con){
    check_mysqliPrepareReturn($delete_stmt = mysqli_prepare($con, "DELETE FROM users WHERE id=?"), $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($delete_stmt, "i", $id), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($delete_stmt), $con);
    if (!mysqli_stmt_affected_rows($delete_stmt)) {
        $_SESSION['error_message'] = 'Eliminazione fallita, si prega di riprovare più tardi';   
        error_log("Failed to delete user from the database: ". mysqli_error($con) ."\n", 3, "error.log"); 
        return;
    } 
    $_SESSION['message'] = 'Utente eliminato con successo';
    mysqli_stmt_close($delete_stmt);      
}

//CHECKED
function add_RememberMe($token, $expiration, $con){
    $add_cookie_stmt = mysqli_prepare($con, "UPDATE users SET rememberMeToken=?, cookie_expiration=? WHERE email=?");
    check_mysqliPrepareReturn($add_cookie_stmt, $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($add_cookie_stmt, "sss", $token, $expiration, $_SESSION["email"]), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($add_cookie_stmt), $con);

    if (mysqli_stmt_affected_rows($add_cookie_stmt)<=0) {
        $_SESSION['error_message'] = "Purtroppo non siamo riusciti a memorizzare l'opazione RememberMe, riprova più tardi";
        error_log("Failed to add cookie to the database: ". mysqli_error($con) ."\n", 3, "error.log");
        mysqli_stmt_close($add_cookie_stmt);
    }          
    mysqli_stmt_close($add_cookie_stmt);
}

//CHECKED
function remove_RememberMe($con){
    $remove_cookie_stmt = mysqli_prepare($con, "UPDATE users SET rememberMeToken=?, cookie_expiration=? WHERE email=?");
    check_mysqliPrepareReturn($remove_cookie_stmt, $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($remove_cookie_stmt, "sss", $nullToken, $nullToken, $_SESSION["email"]), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($remove_cookie_stmt), $con);

    if (mysqli_stmt_affected_rows($remove_cookie_stmt)<=0) {
        $_SESSION['error_message'] = "Si è verificato un errore, riprovare più tardi";
        error_log("Failed to remove cookie from the database: ". mysqli_error($con) ."\n", 3, "error.log");
        mysqli_stmt_close($remove_cookie_stmt);
        return;
    }      
    mysqli_stmt_close($remove_cookie_stmt);
}
?>