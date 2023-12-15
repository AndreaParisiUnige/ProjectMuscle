<?php
ob_start();
require_once 'show_profile.php';
?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    checkNotEmptyParams($_POST["firstname"], $_POST["lastname"], $_POST["email"]);
    validateEmail($_POST["email"]);
    $email = trim($_POST["email"]);

    $dataToUpdate = [
        "nome" => $_POST["firstname"],
        "cognome" => $_POST["lastname"],
        "email" => $email
    ];

    if (isset($_POST["phone"]) && !empty($_POST["phone"]))
        $dataToUpdate["telefono"] = $_POST["phone"];
    if (isset($_POST["address"]) && !empty($_POST["address"]))
        $dataToUpdate["indirizzo"] = $_POST["address"];
    if (isset($_POST["age"]) && !empty($_POST["age"]))
        $dataToUpdate["eta"] = $_POST["age"];

    $user = genericSelect("users", ['id'], 'email=?', [$_SESSION['email']], $con);

    try {
        if (update_UserData("users", $dataToUpdate, "id=?", [$user['id']], $con)) {
            $_SESSION['message'] = 'Profilo aggiornato';
            $_SESSION['email'] = $email;
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Nessuna modifica effettuata";
        error_log("Failed to update " . ($_SESSION["email"]) . "'s data in the database: " . $e->getMessage() . "\n", 3, "error.log");
    }
    mysqli_close($con);
    header("Location: show_profile.php");
}
?>

<script>
    function enableInputs() {
        document.getElementById("firstname").readOnly = false;
        document.getElementById("lastname").readOnly = false;
        document.getElementById("email").readOnly = false;
        document.getElementById("address").readOnly = false;
        document.getElementById("phone").readOnly = false;
        document.getElementById("age").readOnly = false;
    }
    enableInputs();
</script>
<script defer src="validateInput.js"></script>