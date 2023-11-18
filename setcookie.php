<?php
    require_once 'connection.php';
    require_once 'query.php';

    if(isset($_POST['checkbox']) && $_POST['checkbox'] == 'on'){
        if(!isset($_COOKIE["token"])){
            $token = password_hash(random_bytes(16), PASSWORD_DEFAULT); 
            $expiration = time() + (86400 * 30);
            setcookie("token", $token, $expiration, "/");
            add_RememberMe($token, date('Y-m-d', $expiration), $con);
        }
    }
?>