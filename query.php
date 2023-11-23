<?php
/*  La logica di controllo degli errori applicata è la seguente: se falliscono funzioni
    il cui motivo di fallimento è noto (es. tentativo di inserire un utente già esistente)
    viene stampato un messaggio di errore specifico all'utente. 
    Se invece fallisce una funzione il cui motivo di fallimento non è noto, viene memorizzato
    su un file di log l'errore e si invia all'utente un messaggio d'errore generico.
*/
require_once 'utils.php';
set_error_handler("errorHandler");

function insert_user_data($name, $lastname, $email, $hash, $con){

    $insert_stmt = mysqli_prepare($con, "INSERT INTO users (id, nome, cognome, email, password, registration_date, admin)
                                VALUES (NULL, ?, ?, ?, ?, NULL, 0)");

    check_mysqliPrepareReturn($insert_stmt, $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($insert_stmt, "ssss", $name, $lastname, $email, $hash), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($insert_stmt), $con);

    if (mysqli_stmt_affected_rows($insert_stmt)) 
        echo '<h3>Registrazione completata<h3>'; 
    else 
        echo '<h3>Registrazione fallita, si prega di riprovare più tardi</h3>';    
    mysqli_stmt_close($insert_stmt);
}

function get_pwd_fromUser($email, $con){

    check_mysqliPrepareReturn($get_pwd = mysqli_prepare($con, "SELECT password, admin FROM users WHERE email=?"), $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($get_pwd, "s", $email), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($get_pwd), $con);
    $result = mysqli_stmt_get_result($get_pwd);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        return array ($row["password"], $row["admin"]);
    }
    return null;
}

function delete_user($id, $con){
    check_mysqliPrepareReturn($delete_stmt = mysqli_prepare($con, "DELETE FROM users WHERE id=?"), $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($delete_stmt, "i", $id), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($delete_stmt), $con);
    if (mysqli_stmt_affected_rows($delete_stmt)) {
        mysqli_stmt_close($delete_stmt);
        return true;  
    }             
    echo '<h3>Eliminazione fallita, si prega di riprovare più tardi</h3>';   
    error_log("Failed to delete user from the database: ". mysqli_error($con) ."\n", 3, "error.log");   
    mysqli_stmt_close($delete_stmt);   
    return false;    
}

function add_RememberMe($token, $expiration, $con){

    $add_cookie_stmt = mysqli_prepare($con, "UPDATE users SET rememberMeToken=?, cookie_expiration=?, remember_me_enabled=1 WHERE email=?");
    check_mysqliPrepareReturn($add_cookie_stmt, $con);

    check_mysqliBindReturn(mysqli_stmt_bind_param($add_cookie_stmt, "sss", $token, $expiration, $_SESSION["email"]), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($add_cookie_stmt), $con);

    if (mysqli_stmt_affected_rows($add_cookie_stmt)<=0) {
        echo "<span>Si è verificato un errore, riprovare più tardi</span>";
        error_log("Failed to add cookie to the database: ". mysqli_error($con) ."\n", 3, "error.log");
    }          
    mysqli_stmt_close($add_cookie_stmt);
}

function remove_RememberMe($con){

    $remove_cookie_stmt = mysqli_prepare($con, "UPDATE users SET rememberMeToken=?, cookie_expiration=?, remember_me_enabled=0 WHERE email=?");
    check_mysqliPrepareReturn($remove_cookie_stmt, $con);

    check_mysqliBindReturn(mysqli_stmt_bind_param($remove_cookie_stmt, "sss", $nullToken, $nullToken, $_SESSION["email"]), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($remove_cookie_stmt), $con);

    if (mysqli_stmt_affected_rows($remove_cookie_stmt)<=0) {
        echo "<span>Si è verificato un errore, riprovare più tardi</span>";
        error_log("Failed to remove cookie from the database: ". mysqli_error($con) ."\n", 3, "error.log");
    }      
    mysqli_stmt_close($remove_cookie_stmt);
}

function checkValideCookie($token, $con){
    $check_cookie_stmt = mysqli_prepare($con, "SELECT email, admin, rememberMeToken, cookie_expiration, remember_me_enabled FROM users WHERE rememberMeToken=?");
    check_mysqliPrepareReturn($check_cookie_stmt, $con);

    check_mysqliBindReturn(mysqli_stmt_bind_param($check_cookie_stmt, "s", $token), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($check_cookie_stmt), $con);
    $result = mysqli_stmt_get_result($check_cookie_stmt);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        if ($row["remember_me_enabled"] && $row["rememberMeToken"] == $token && strtotime($row["cookie_expiration"]) > time()) {
            $_SESSION["logged_in"] = true;
            $_SESSION["email"] = $row["email"];
            $_SESSION["admin"] = $row["admin"];  
            mysqli_stmt_close($check_cookie_stmt);      
            return true;     
        }
    }
    else error_log("The cookie obtained from the browser does not have matches in the database: ". mysqli_error($con) ."\n", 3, "error.log");
    mysqli_stmt_close($check_cookie_stmt);
    return false;
}

?>