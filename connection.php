<?php
	$servername = "localhost";
	$username = "andrea";
	$password = "QygA@5P[CO-ikKbp";
	$dbname = "sawdata";

	try{
    $con = mysqli_connect($servername, $username, $password, $dbname);
	}	
	catch(Exception $e){
		error_log("Errore durante la connessione al database:".$e->getMessage()."\n", 3, "error.log");
		$_SESSION["error_message"] = "Something went wrong, visit us again later";	
		$previous_page = $_SERVER['HTTP_REFERER'];	
		header("Location: $previous_page");
		exit;
	}
?>