<?php
/*  La logica di controllo degli errori applicata è la seguente: se falliscono funzioni
    il cui motivo di fallimento è noto (es. tentativo di inserire un utente già esistente)
    viene stampato un messaggio di errore specifico all'utente. 
    Se invece fallisce una funzione il cui motivo di fallimento non è noto, viene memorizzato
    su un file di log l'errore e si invia all'utente un messaggio d'errore generico.
*/
require_once 'utils.php';
set_error_handler("errorHandler");

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

//CHECKED
function get_pwd_fromUser($email, $con){
    check_mysqliPrepareReturn($get_pwd = mysqli_prepare($con, "SELECT password, admin FROM users WHERE email=?"), $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($get_pwd, "s", $email), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($get_pwd), $con);
    $result = mysqli_stmt_get_result($get_pwd);
    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        return array ($row["password"], $row["admin"]);
    }
    return null;
}

function get_User($email, $con){
    check_mysqliPrepareReturn($get_pwd = mysqli_prepare($con, "SELECT email FROM users WHERE email=?"), $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($get_pwd, "s", $email), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($get_pwd), $con);
    $result = mysqli_stmt_get_result($get_pwd);
    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        return $row["email"];
    }
    return null;
}

function delete_user($id, $con){
    check_mysqliPrepareReturn($delete_stmt = mysqli_prepare($con, "DELETE FROM users WHERE id=?"), $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($delete_stmt, "i", $id), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($delete_stmt), $con);
    if (!mysqli_stmt_affected_rows($delete_stmt)) {
        $_SESSION['error_message'] = '<h3>Eliminazione fallita, si prega di riprovare più tardi</h3>';   
        error_log("Failed to delete user from the database: ". mysqli_error($con) ."\n", 3, "error.log"); 
        return;
    } 
    $_SESSION['message'] = '<h3>Utente eliminato</h3>';
    mysqli_stmt_close($delete_stmt);      
}

//CHECKED
function add_RememberMe($token, $expiration, $con){
    $add_cookie_stmt = mysqli_prepare($con, "UPDATE users SET rememberMeToken=?, cookie_expiration=? WHERE email=?");
    check_mysqliPrepareReturn($add_cookie_stmt, $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($add_cookie_stmt, "sss", $token, $expiration, $_SESSION["email"]), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($add_cookie_stmt), $con);

    if (mysqli_stmt_affected_rows($add_cookie_stmt)<=0) {
        $_SESSION['error_message'] = "<span>Purtroppo non siamo riusciti a memorizzare l'opazione RememberMe, riprova più tardi</span>";
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
        $_SESSION['error_message'] = "<span>Si è verificato un errore, riprovare più tardi</span>";
        error_log("Failed to remove cookie from the database: ". mysqli_error($con) ."\n", 3, "error.log");
        mysqli_stmt_close($remove_cookie_stmt);
        return;
    }      
    mysqli_stmt_close($remove_cookie_stmt);
}

//TESTED
function checkValideCookie($token, $con){
    $check_cookie_stmt = mysqli_prepare($con, "SELECT email, admin, rememberMeToken, cookie_expiration FROM users WHERE rememberMeToken=? AND cookie_expiration > NOW()");
    check_mysqliPrepareReturn($check_cookie_stmt, $con);
    check_mysqliBindReturn(mysqli_stmt_bind_param($check_cookie_stmt, "s", $token), $con);
    check_mysqliExecuteReturn(mysqli_stmt_execute($check_cookie_stmt), $con);
    $result = mysqli_stmt_get_result($check_cookie_stmt);

    if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_array($result);
            $_SESSION["logged_in"] = true;
            $_SESSION["email"] = $row["email"];
            $_SESSION["admin"] = $row["admin"];  
            mysqli_stmt_close($check_cookie_stmt);      
            return true;     
    }
    else 
        error_log("The cookie " . $token . " obtained from the browser at ". date('d-m-Y H:i:s') ." does not have matches in the database.\n", 3, "error.log");
    mysqli_stmt_close($check_cookie_stmt);
    return false;
}

?>