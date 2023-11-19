<?php
session_start();
require_once 'header.php';
require_once 'navbar.php';

try{   
    if (isset($_SESSION["logged_in"]) && $_SESSION["admin"] == 1) {
        require_once ("connection.php");
        $query = "SELECT id, nome, cognome, email, admin FROM users"; // prepared statement non necessario non essendo presenti dati esterni
        if ($res = mysqli_query($con, $query)){
            if(mysqli_num_rows($res) > 0){
                while($row = mysqli_fetch_assoc($res))
                if ($row["admin"] == 0) {
                    echo "<p>".$row["nome"]." ".$row["cognome"]." ".$row["email"];
                    echo "<form method='post' action='deleteUser.php'>";
                    echo "<input type='hidden' name='deleteUser'>";
                    echo "<input type='hidden' name='id' value='".$row["id"]."'>";
                    echo "<input type='hidden' name='email' value='".$row["email"]."'>";
                    echo "<button type='submit'>X</button>";
                    echo "</form></p>";
                }
            }
            else {
                echo "<p>Nessun utente registrato</p>";
                exit;
            }
            mysqli_free_result($res);
        }
        else {
            echo "<p>Errore: si prega di riprovare più tardi</p>";
            error_log("Failed to access data: ".mysqli_error($con)."\n", 3, "error.log");
        }
        mysqli_close($con);
        exit;
    }
    else {
        header("Location: login.php");
        exit;
    }
}catch (Exception $e) {
    echo "<p>Errore: impossibile accedere ai dati</p>";
    error_log("Failed to access data: ".$e->getMessage()."\n", 3, "error.log");
    exit;
}
?>