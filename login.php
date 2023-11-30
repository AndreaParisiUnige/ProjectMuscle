<?php
session_start();
ob_start();
require_once 'header.php'; // Header contains the set_error_handler and the require_once for utils.php; 
?>

<?php //TESTED
if ($_SERVER["REQUEST_METHOD"] === "POST") {

	checkNotEmptyParams($_POST["email"], $_POST["pass"]);
	validateEmail($_POST["email"]);

	require_once 'connection.php';
	require_once 'query.php';

	$email = trim($_POST["email"]);
	$clean_pass = trim(($_POST["pass"]));

	try {
		$user = get_pwd_fromUser($email, $con);
	} catch (Exception $e) {
		$_SESSION["error_message"] = "<span>Something went wrong</span>";
		header("Location: login.php");
		error_log("Failed to search user data from the database: " . $e->getMessage() . "\n", 3, "error.log");
	}

	if (!empty($user))
		if (password_verify($clean_pass, $user[0])) {
			$_SESSION["logged_in"] = true;
			$_SESSION["email"] = $email;
			$_SESSION["admin"] = $user[1];

			require_once 'setcookie.php';
			mysqli_close($con);
			header("Location: reserved.php");
			exit;
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
	</form>

	<?php
	checkSessionError();	//Here to visualize error messages in the form
	checkSessionMessage();	//Here to visualize success messages in the form
	?>
</div>

<script defer src="validateInput.js"></script>

<?php
require_once 'footer.php';
?>