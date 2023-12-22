<?php
ob_start();
session_start();
require_once '../utility/query.php';
set_error_handler("errorHandler");
exitIfNotAdmin($con);

$id = requireId();
if (!$id){
    http_response_code(500);
    exit;
}
if(isset($_POST['table']) && isset($_POST['idName'])){
    $table = $_POST['table'];
    $idName = $_POST['idName'];
}
else{
    http_response_code(500);
    exit;
}

try {
    $articleExists = genericSelect($table, [$idName], $idName . "=?", [$idName => $id], $con);
    if (!$articleExists) {
        http_response_code(404);
        exit;
    }
    if (generic_delete($table, $idName . "=?", [$id], $con)){
        http_response_code(200);
        header("Location: ../structure/index.php");
    }
    else 
        http_response_code(500);
        
} catch (Exception $e) {
    http_response_code(500);
    error_log("Failed to delete article " . ($id) . " from the database: " . $e->getMessage() . "\n", 3, "error.log");
}
exit;