<?php
session_start();
ob_start();
?>

<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'utils.php';
?>

<div class="form-container">
	<h1>Inserisci i tuoi dati</h1>
	<form action="login.php" method="post">
		<label for="email" class="label">Email:</label>
		<input type="email" id="email" name="email" class="input-field" required>

		<label for="pass" class="label">Password:</label>
		<input type="password" id="pass" name="pass" class="input-field" required>

		<input type="submit" value="Submit" class="submit-button">
	</form>

	<?php
	try{

		checkSessionError();

		if ($_SERVER["REQUEST_METHOD"] === "POST") {

			checkNotEmptyParams($_POST["email"], $_POST["pass"]);
			validateEmail($_POST["email"]);

			require_once 'connection.php';
			require_once 'query.php';

			$email = trim($_POST["email"]);
			$clean_pass = trim(($_POST["pass"]));

			// Ricerco l'utente nel database, se non esiste $user[0] sarà 0
			$user = get_pwd_fromUser($email, $con);
			if(empty($user) || !password_verify($clean_pass, $user[0])){
				$_SESSION["error_message"] = "Errore: email o password errati";
				header("Location: login.php");				
				exit;
			}
			
			$_SESSION["logged_in"] = true;
			$_SESSION["email"] = $email;
			$_SESSION["admin"] = $user[1];

			mysqli_close($con);
			header("Location: reserved.php");
		}
	} catch (Exception $e){
		echo "<span>Something went wrong</span>";
		error_log("Failed to search user data from the database: ".$e->getMessage()."\n", 3, "error.log");
	}
	?>
	
</div>

<?php
	require_once 'footer.php';
?>