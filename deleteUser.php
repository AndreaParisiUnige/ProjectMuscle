<?php
    require_once ("utils.php");
    ob_start();
    set_error_handler("errorHandler");
    session_start();

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]===true && isset($_SESSION["admin"]) && $_SESSION["admin"]===1) {
        if (isset($_GET["id"]) && is_numeric($_GET["id"]))
            $id = $_GET["id"];           
        else if (isset($_POST["id"]) && is_numeric($_POST["id"]))
            $id = $_POST["id"];              
        else {
            header("Location: allusers.php");
            exit;
        }
        require_once ("connection.php");
        require_once ("query.php");
        try{
            if (delete_user($id, $con))
                $_SESSION['message'] = 'Utente eliminato con successo';
        }catch(Exception $e){
            $_SESSION['error_message'] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi";
		    error_log("Failed to delete ". ($id). " data from the database: " . $e->getMessage() . "\n", 3, "error.log");
        }
        header("Location: allusers.php");
        exit;
    }
    else {
        header("Location: login.php");
        exit;
    }
?>