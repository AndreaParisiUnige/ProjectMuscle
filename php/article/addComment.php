<?php
session_start();
ob_start();
require_once '../utility/query.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comment"])) {
    if (!isset($_SESSION["email"])) {
        $_SESSION["error_message"] = "Per poter commentare devi essere loggato.";
        header("Location: ../user/login.php");
        exit;
    }
    $comment = htmlspecialchars($_POST["comment"]);
    $user = htmlspecialchars($_POST["user"]);
    $article = $_POST["article"];

    if (generic_Insert("commenti", ["articolo" => $article, "utente" => $user, "testo" => $comment], $con)) {
        $_SESSION["message"] = "Commento inserito con successo.";
    } else {
        $_SESSION["error_message"] = "Errore nell'inserimento del commento.";
    }
    header("Location: ../article/article.php?id=$article");
}
?>