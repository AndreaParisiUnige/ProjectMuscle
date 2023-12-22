<?php
require_once("../utility/query.php");
session_start();
if (!check_alreadyLoggedIn($con)) {
    header("Location: ../user/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Necessario in caso di modifica della sola password, in quanto i campi vengono inviati vuoti
    if (isSetAndNotEmpty($_POST["firstname"]) ||  isSetAndNotEmpty($_POST["lastname"]) || isSetAndNotEmpty($_POST["email"])) {
        checkNotEmptyParams($_POST["firstname"], $_POST["lastname"], $_POST["email"]);
        validateEmail($_POST["email"]);
        $email = trim($_POST["email"]);

        $dataToUpdate = [
            "nome" => $_POST["firstname"],
            "cognome" => $_POST["lastname"],
            "email" => $email
        ];

        if (isset($_POST["phone"]))
            $dataToUpdate["telefono"] = $_POST["phone"];
        if (isset($_POST["address"]))
            $dataToUpdate["indirizzo"] = $_POST["address"];
        if (isset($_POST["age"]))
            $dataToUpdate["eta"] = $_POST["age"];
    } 
    else if (isset($_POST["pass"]) || isset($_POST["confirm"])) {
        checkNotEmptyParams($_POST["pass"], $_POST["confirm"]);
        validatePassword($_POST["pass"], $_POST["confirm"]);
        $dataToUpdate["password"] =  password_hash(trim(($_POST["pass"])), PASSWORD_DEFAULT);
    }
    try {
        $user = genericSelect("users", ['id'], 'email=?', [$_SESSION['email']], $con);
        if ($user) {
            if (generic_Update("users", $dataToUpdate, "id=?", [$user['id']], $con)) {
                $_SESSION['message'] = 'Profilo aggiornato';
                $_SESSION['email'] = isset($email) ? $email : $_SESSION['email'];   // Se aggiornata la mail aggiorno anche la sessione
            }
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Nessuna modifica effettuata";
        error_log("Failed to update " . ($_SESSION["email"]) . "'s data in the database: " . $e->getMessage() . "\n", 3, "error.log");
    }
    mysqli_close($con);
    header("Location: show_profile.php");
}
