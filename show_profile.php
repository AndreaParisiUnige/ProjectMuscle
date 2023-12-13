<?php
require_once 'header.php';

if (isset($_COOKIE["token"])) {
    if ($row = genericSelect("users", SELECT_COOKIE, WHERE_STMT_COOKIE, [$_COOKIE["token"]], $con))
        setSessionParams($row);
}
if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit();
}
try {
    $valuesToSelect = ["nome", "cognome", "email", "telefono", "indirizzo", "eta"];
    $row = genericSelect("users", $valuesToSelect , "email=?", [$_SESSION["email"]], $con);
}
catch (Exception $e) {
    $_SESSION["error_message"] = "Qualcosa è andato storto...Riprova pià tardi";
    header("Location: index.php");
    error_log("Failed to search user data from the database: " . $e->getMessage() . "\n", 3, "error.log");
}
?>

<div class="container">
    <div class="profile">
        <?php 
        checkSessionError();
        checkSessionMessage();
        ?>
        <div class="profile_image"></div>
        <div class="profile_info">
            <!-- FORM -->
            <form action="update_profile.php" method="post" id="updateProfile" novalidate>
                <input hidden type="text" id="sectionTitle" value="Profile">
                    <!-- COLONNE -->
                    <div class="columns">
                        <div class="col1">
                            <div class="input-control2">
                                <label for="firstname">Nome:</label>
                                <input type="text" id="firstname" name="firstname" value=<?php echo $row["nome"]?> readonly>
                            </div>

                            <div class="input-control2">
                                <label for="email" class="label">Email:</label>
                                <input type="email" id="email" name="email" value=<?php echo $row["email"]?> readonly>
                            </div>

                            <div class="input-control2">
                                <label for="address" class="label">Indirizzo:</label>
                                <input type="text" id="address" name="address" readonly value= <?php echo isset($row["indirizzo"]) ? $row["indirizzo"] : null?> >
                            </div>
                        </div>

                        <div class="col2">
                            <div class="input-control2">
                                <label for="lastname" class="label">Cognome:</label>
                                <input type="text" id="lastname" name="lastname" value=<?php echo $row["cognome"]?> readonly>
                            </div>

                            <div class="input-control2">
                                <label for="phone" class="label">Telefono:</label>
                                <input type="text" id="phone" name="phone" readonly value=<?php echo isset($row["telefono"]) ? $row["telefono"] : null?> >
                            </div>

                            <div class="input-control2">
                                <label for="age" class="age">Età:</label>
                                <input type="text" id="age" name="age" readonly value=<?php echo isset($row["eta"]) ? $row["eta"] : null?> >
                            </div>
                        </div>
                    </div>
                    <button id="submit_button_profile" type="submit">Update</button>
            </form>
        </div>
    </div>
</div>

<script>
    addEventListener("DOMContentLoaded", function () {
        if (page == "show_profile.php")
            document.getElementById('updateProfile').addEventListener('submit', function(event) {
                event.preventDefault(); // Evita il comportamento predefinito di invio del form
                window.location = this.action;
            });
    });
</script>