<?php
ob_start();
require_once '../structure/header.php'; 
exitIfLogged($con);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

	checkNotEmptyParams($_POST["email"], $_POST["pass"]);
	validateEmail($_POST["email"]);

	$email = trim($_POST["email"]);
	$clean_pass = trim(($_POST["pass"]));

	try {
		$res = genericSelect("users", ['password', 'admin'], 'email=?', [$email], $con);
	} catch (Exception $e) {
		$_SESSION["error_message"] = "Qualcosa è andato storto...Riprova pià tardi";
		header("Location: ../user/login.php");
		error_log("Failed to search user data from the database: " . $e->getMessage() . "\n", 3, "error.log");
	}

	if (!empty($res)) {
		if (password_verify($clean_pass, $res["password"])) {
			$_SESSION["logged_in"] = true;
			$_SESSION["email"] = $email;
			$_SESSION["admin"] = $res["admin"];

			require_once '../utility/setcookie.php';
			mysqli_close($con);
			header("Location: ../structure/index.php");
			exit;
		}
	}
	$_SESSION["error_message"] = "Errore: email o password errati\n";
	reloadPage();
	exit;
}
?>


<div class="main_content">
	<form class="inputForm" id="form" action="login.php" method="post" novalidate>
	<input hidden type="text" id="sectionTitle" value="Login">
		<div class="input-control">
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" placeholder="Enter your email">
		</div>
		<div class="input-control">
			<label for="pass">Password:</label>
			<input type="password" id="pass" name="pass" placeholder="Enter your password">
		</div>
		<label for="checkbox" class="checkboxSect">
			<input type="checkbox" id="checkbox" name="checkbox">
			<span>Remember Me</span>
		</label>
		<button class="responsive small small-elevate" id="submit_button" type="submit">Accedi</button>
	</form>
</div>

<script defer src="../../js/validateInput.js"></script>

<?php
require_once '../structure/footer.php';
?>