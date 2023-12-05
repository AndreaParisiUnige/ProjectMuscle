<?php
    require_once 'connection.php';
    require_once 'query.php';

    if(isset($_POST['checkbox']) && $_POST['checkbox'] == 'on' && isset($_SESSION['email'])){
        $token = password_hash(random_bytes(16), PASSWORD_DEFAULT); 
        $expiration = time() + (86400 * 30);
        setcookie("token", $token, $expiration, "/");
        try {
            manage_RememberMe($con, $token, date('Y-m-d', $expiration), $_SESSION["email"]);
        }
        catch (Exception $e){
            $_SESSION['error_message'] = "Non è stato possibile memorizzare l'opzione 'remember me'. Riprova più tardi.";
            error_log("Failed to save remember me for user " . $_SESSION["email"] . ": " . $e->getMessage() . "\n", 3, "error.log");
        }
    }
?>