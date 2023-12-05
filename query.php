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

function insert_user_data($name, $lastname, $email, $hash, $con){

    $query = "INSERT INTO users (id, nome, cognome, email, password, registration_date, admin) VALUES (NULL, ?, ?, ?, ?, NULL, 0)";
    check_mysqliFunction($insert_stmt = mysqli_prepare($con, $query), $con, 'prepare', $query);
    check_mysqliFunction(mysqli_stmt_bind_param($insert_stmt, "ssss", $name, $lastname, $email, $hash), $con, 'bind', $query);
    check_mysqliFunction(mysqli_stmt_execute($insert_stmt), $con, 'execute', $query);

    if (mysqli_stmt_affected_rows($insert_stmt)) {
        mysqli_stmt_close($insert_stmt);
        return true;   
    }
    mysqli_stmt_close($insert_stmt);
}

function delete_user($id, $con){
    $query = "DELETE FROM users WHERE id=?";
    check_mysqliFunction($delete_stmt = mysqli_prepare($con, $query), $con, 'prepare', $query);
    check_mysqliFunction(mysqli_stmt_bind_param($delete_stmt, "i", $id), $con, 'bind', $query);
    check_mysqliFunction(mysqli_stmt_execute($delete_stmt), $con, 'execute', $query);
    if (mysqli_stmt_affected_rows($delete_stmt)) {
        mysqli_stmt_close($delete_stmt);  
        return true;
    } 
    mysqli_stmt_close($delete_stmt);  
}

function manage_RememberMe($con, $token, $expiration, $email){
    $query = "UPDATE users SET rememberMeToken=?, cookie_expiration=? WHERE email=?";
    check_mysqliFunction($stmt = mysqli_prepare($con, $query), $con, 'prepare', $query);
    check_mysqliFunction(mysqli_stmt_bind_param($stmt, "sss", $token, $expiration, $email), $con, 'bind', $query);
    check_mysqliFunction(mysqli_stmt_execute($stmt), $con, 'execute', $query);

    if (!mysqli_stmt_affected_rows($stmt)) 
        throw new Exception($token. ": " . mysqli_error($con) ."\n");
    mysqli_stmt_close($stmt);
}
?>