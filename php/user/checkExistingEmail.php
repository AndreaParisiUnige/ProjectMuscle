<?php
ob_start();
require_once '../utility/query.php';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST['email'])) {
        try {
            if (genericSelect("users", ['email'], 'email=?', [$_POST['email']], $con) != null)
                $existing_User = true;
            else
                $existing_User = false;
            header('Content-Type: application/json');
            echo json_encode(array("existing_User" => $existing_User));
        } catch (Exception $e) {
            error_log("Failed to search user from the database: " . $e->getMessage() . "\n", 3, "error.log");
            echo json_encode(array("error" => "Errore interno"));
        }
    } else
        echo json_encode(array("error" => "Email non fornita"));
} else
    echo json_encode(array("error" => "Metodo di richiesta non consentito"));
