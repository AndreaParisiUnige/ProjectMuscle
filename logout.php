<?php 
    session_start();   
    ob_start(); 
?>

<?php
    require_once 'connection.php'; 
    require_once 'utils.php';
    require_once 'query.php';
    set_error_handler("errorHandler");

    try{
        if(isset($_COOKIE["token"])){
            $expiration = time() - (86400 * 30);
            setcookie("token", "deleted", $expiration, "/");
            remove_RememberMe($con);
        }
        session_destroy();
        header("Location: index.php");
        exit();
    }
    catch(Exception $e){
        echo "<span>Something went wrong</span>";
		error_log("Failed to logout user: ".$e->getMessage()."\n", 3, "error.log");
    }
?>
