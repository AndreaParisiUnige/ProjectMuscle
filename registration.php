<?php
session_start();
require_once 'utils.php';
require_once 'header.php';
require_once 'navbar.php';
?>

<?php

if (
	(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) 
	|| (isset($_COOKIE["token"]) && genericSelect("users", SELECT_PARAMS, WHERE_STMT, [$_COOKIE["token"]], $con))
) {
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
			$_SESSION['message'] = 'Registrazione completata';
			header("Location: login.php");
			exit;
		}
	} catch (Exception $e) {
		$_SESSION['error_message'] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi";
		error_log("Failed to insert ". ($_POST["email"]). " data into the database: " . $e->getMessage() . "\n", 3, "error.log");
		reloadPage();
	}
	mysqli_close($con);
	exit;
}
?>

<div>
	<form id=form action="registration.php" method="post" novalidate>
	<h3>Registrazione</h3>
		<div class="input-control">
			<label for="firstname">Nome:</label>
			<input type="text" id="firstname" name="firstname" placeholder="Enter your name">
		</div>

		<div class="input-control">
			<label for="lastname" class="label">Cognome:</label>
			<input type="text" id="lastname" name="lastname" placeholder="Enter your surname">
		</div>

		<div class="input-control">
			<label for="email" class="label">Email:</label>
			<input type="email" id="email" name="email" placeholder="Enter your email" >
		</div>

		<div class="input-control">
			<label for="pass" class="label">Password:</label>
			<input type="password" id="pass" name="pass" placeholder="Enter your password">
		</div>

		<div class="input-control">
			<label for="confirm" class="label">Conferma password:</label>
			<input type="password" id="confirm" name="confirm" placeholder="Confirm your password">
		</div>
		<button class="responsive secondary small small-elevate" type="submit">Sign in</button>
		<div class="space"></div>

		<?php
		checkSessionError();
		?>
	</form>
</div>

<script defer src="validateInput.js"></script>

<?php
require_once 'footer.php';
?>