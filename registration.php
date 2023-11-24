<?php
session_start();
?>

<?php
require_once 'utils.php';
require_once 'header.php';
require_once 'navbar.php';
?>

<?php
if ((isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) || (isset($_COOKIE["token"]) && checkValideCookie($_COOKIE["token"], $con))) {
	header("Location: index.php");
	exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

	checkNotEmptyParams($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["pass"], $_POST["confirm"]);
	validateEmail($_POST["email"]);
	validatePassword($_POST["pass"], $_POST["confirm"]);

	try {
		require_once 'connection.php';
		require_once 'query.php';
		$hash =  password_hash(trim(($_POST["pass"])), PASSWORD_DEFAULT);
		if (insert_user_data($_POST["firstname"], $_POST["lastname"], trim($_POST["email"]), $hash, $con)) {
			$_SESSION['message'] = '<span>Registrazione completata<span>';
			header("Location: login.php");
			exit;
		}	
	} 
	catch (Exception $e) {
		if (mysqli_errno($con) == 1062)	
			$_SESSION['error_message'] = "<span>Errore:account già registrato</span>";
		else
			$_SESSION['error_message'] = "<span>Something went wrong</span>";
		error_log("Failed to insert user data into the database: " . $e->getMessage() . "\n", 3, "error.log");
		reloadPage();
	}
	mysqli_close($con);
	exit;
}
?>

<div class="form-container">
	<h1>Inserisci i tuoi dati</h1>
	<form action="registration.php" method="post">

		<label for="firstname" class="label">First name:</label>
		<input type="text" id="firstname" name="firstname" class="input-field" required>

		<label for="lastname" class="label">Last name:</label>
		<input type="text" id="lastname" name="lastname" class="input-field" required>

		<label for="email" class="label">Email:</label>
		<input type="email" id="email" name="email" class="input-field" required>

		<label for="pass" class="label">Password:</label>
		<input type="password" id="pass" name="pass" class="input-field" required>

		<label for="confirm" class="label">Confirm password:</label>
		<input type="password" id="confirm" name="confirm" class="input-field" required>

		<input type="submit" value="Submit" class="submit-button">
	</form>

	<?php
	checkSessionError();
	?>
</div>

<?php
require_once 'footer.php';
?>