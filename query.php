<?php
/*  La logica di controllo degli errori applicata è la seguente: se falliscono funzioni
    il cui motivo di fallimento è noto (es. tentativo di inserire un utente già esistente)
    viene stampato un messaggio di errore specifico all'utente. 
    Se invece fallisce una funzione il cui motivo di fallimento non è noto, viene memorizzato
    su un file di log l'errore e si invia all'utente un messaggio d'errore generico.
*/
require_once 'utils.php';
set_error_handler("errorHandler");

/*
function verify_existing_user($email, $con){

    $verify_existing_user = mysqli_prepare($con, "SELECT id FROM users WHERE email=?");
    mysqli_stmt_bind_param($verify_existing_user, "s", $email);

    mysqli_stmt_execute($verify_existing_user);
    mysqli_stmt_store_result($verify_existing_user);
    if(mysqli_stmt_num_rows($verify_existing_user) >= 1)
        echo "<span>Utente già registrato</span>";

    return mysqli_stmt_num_rows($verify_existing_user);
}
*/

function insert_user_data($name, $lastname, $email, $hash, $con){

    $insert_stmt = mysqli_prepare($con, "INSERT INTO users (id, nome, cognome, email, password, registration_date, admin) 
                                VALUES (NULL, ?, ?, ?, ?, NULL, 0)");

    check_mysqliPrepareReturn($insert_stmt, $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($insert_stmt, "ssss", $name, $lastname, $email, $hash), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($insert_stmt), $con);

    if (mysqli_stmt_affected_rows($insert_stmt)) 
        echo '<h3>Registrazione completata<h3>';         
    mysqli_stmt_close($insert_stmt);
}

function get_pwd_fromUser($email, $con){

    check_mysqliPrepareReturn($get_pwd = mysqli_prepare($con, "SELECT password, admin FROM users WHERE email=?"), $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($get_pwd, "s", $email), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($get_pwd), $con);
    check_mysqliGetResultReturn($result = mysqli_stmt_get_result($get_pwd), $con);

    if($result->num_rows == 0)
        return array ();
    $row = mysqli_fetch_array($result);
    return array ($row["password"], $row["admin"]);
}

function delete_user($id, $con){
    check_mysqliPrepareReturn($delete_stmt = mysqli_prepare($con, "DELETE FROM users WHERE id=?"), $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($delete_stmt, "i", $id), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($delete_stmt), $con);
    mysqli_stmt_close($delete_stmt);
    return true;
}

?>