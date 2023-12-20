<?php
ob_start();
require_once '../utility/query.php';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST['email'])){
        if (genericSelect("users", ['email'], 'email=?', [$_POST['email']], $con) != null)
            $existing_User = true;
        else
            $existing_User = false;
        header('Content-Type: application/json'); 
        echo json_encode(array("existing_User" => $existing_User));
    } 
    else {
        echo json_encode(array("error" => "Email non fornita"));
    }
} else {
    echo json_encode(array("error" => "Metodo di richiesta non consentito"));
}
?>