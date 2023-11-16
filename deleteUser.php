<?php
    require_once ("utils.php");
    set_error_handler("errorHandler");
    session_start();

    if (!isset($_SESSION["logged_in"])) {
        header("Location: login.php");
        exit;
    }
    if ($_SESSION["admin"] == 1){
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
        if (delete_user($id, $con))
            echo "<p>User deleted</p>";

        header("Location: allusers.php");
    }
?>