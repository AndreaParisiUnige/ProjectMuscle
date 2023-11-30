<?php
ob_start();
require_once 'connection.php';
require_once 'query.php';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST['email'])){
        if (get_User($_POST['email'], $con) != null)
            $existing_User = true;
        else
            $existing_User = false;

        http_response_code(200);
        header('Content-Type: application/json'); 
        echo json_encode(array("existing_User" => $existing_User));
    } 
    else {
    // Email non fornita: stato 400 (Bad Request)
    http_response_code(400);
    echo json_encode(array("error" => "Email non fornita"));
    }
} else {
// Metodo richiesta diverso da POST: stato 405 (Method Not Allowed)
http_response_code(405);
echo json_encode(array("error" => "Metodo di richiesta non consentito"));
}
?>