<?php
	require_once '../utility/utils.php';
	set_error_handler("errorHandler");	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "sawdata";

	try{
    	$con = mysqli_connect($servername, $username, $password, $dbname);
	}	
	catch(Exception $e){
		error_log("Errore durante la connessione al database:".$e->getMessage()."\n", 3, "error.log");
		$_SESSION["error_message"] = "Qualcosa è andato storto...Riprova più tardi";	
		$previous_page = $_SERVER['HTTP_REFERER'];	
		header("Location: $previous_page");
		exit;
	}
?>