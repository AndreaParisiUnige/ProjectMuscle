<?php
session_start();
ob_start();
require_once 'header.php'; // Header contains the set_error_handler and the require_once for utils.php; 
?>

<?php 
if ($_SERVER["REQUEST_METHOD"] === "POST") {

	checkNotEmptyParams($_POST["email"], $_POST["pass"]);
	validateEmail($_POST["email"]);

	require_once 'connection.php';
	require_once 'query.php';

	$email = trim($_POST["email"]);
	$clean_pass = trim(($_POST["pass"]));

	try {
		$res = genericSelect("users", ['password', 'admin'], 'email=?', [$email], $con);
	} catch (Exception $e) {
		$_SESSION["error_message"] = "Qualcosa è andato storto...Riprova pià tardi";
		header("Location: login.php");
		error_log("Failed to search user data from the database: " . $e->getMessage() . "\n", 3, "error.log");
	}

	if (!empty($res)) {
		if (password_verify($clean_pass, $res["password"])) {
			$_SESSION["logged_in"] = true;
			$_SESSION["email"] = $email;
			$_SESSION["admin"] = $res["admin"];

			require_once 'setcookie.php';
			mysqli_close($con);
			header("Location: reserved.php");
			exit;
		}
	}
	$_SESSION["error_message"] = "Errore: email o password errati\n";
	header("Location: login.php");
	exit;
}
?>

<?php
require_once 'navbar.php';
?>

<div>
	<form id="form" action="login.php" method="post">
		<h3>Login</h3>
		<div class="input-control">
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" placeholder="Enter your email">
		</div>
		<div class="input-control">
			<label for="pass">Password:</label>
			<input type="password" id="pass" name="pass" placeholder="Enter your password">
		</div>
		<label class="checkbox" for="checkbox">
			<input type="checkbox" id="checkbox" name="checkbox">
			<span>Remember Me</span>
		</label>
		<button class="responsive secondary small small-elevate" type="submit">Sign Up</button>
		<div class="space"></div>

		<?php
		checkSessionError();	//Possibily emptyField or wrongData errors
		checkSessionMessage();	//Success message after successful registration
		?>
	</form>
</div>

<script defer src="validateInput.js"></script>

<?php
require_once 'footer.php';
?>