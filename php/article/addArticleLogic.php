<?php
require_once '../utility/query.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['request'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        if ($_POST['request'] === 'add') {
            try {
                if (insert_data("articoli", ["articleNum" => "NULL", "title" => $title, "article" => $content], $con))
                    http_response_code(200);    // OK
                else
                    http_response_code(500);    // Errore interno al server 
            } catch (Exception $e) {
                error_log("Failed to insert data into the database: " . $e->getMessage() . "\n", 3, "error.log");
                http_response_code(500);
            }
        } else if (isset($_POST['articleNum']) && $_POST['request'] === 'update') {
            try {
                if (generic_Update('articoli', ['title' => $title, 'article' => $content], 'articleNum=?', ['articleNum' => $_POST['articleNum']], $con))
                    http_response_code(200);    // OK
                else
                    http_response_code(500);    // Errore interno al server
            } catch (Exception $e) {
                error_log("Failed to update data into the database: " . $e->getMessage() . "\n", 3, "error.log");
                http_response_code(500);
            }
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    http_response_code(405);   // Metodo non consentito
}
