<?php
session_start();
require_once 'query.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comment"])) {
    $comment = htmlspecialchars($_POST["comment"]);
    $user = htmlspecialchars($_POST["user"]);
    $article = $_POST["article"];

    if (insert_data("commenti", ["articolo" => $article, "utente" => $user, "testo" => $comment], $con)) {
        echo "Commento inserito con successo.";
    } else {
        echo "Errore nell'inserimento del commento.";
    }
}
?>