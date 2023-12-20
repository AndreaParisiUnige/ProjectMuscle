<!--
L'accesso alla pagina è consentito solo agli utenti registrati e loggati.
E' possibile accedervi anche in presenza di un cookie di autenticazione valido.
Il controllo effettuato sul cookie di autenticazione trovato verifica l'esistenza e la scadenza dello stesso
In caso di cookie valido vengono settati i parametri di sessione che permetteranno l'accesso alla pagina.
-->

<?php
require_once '../structure/header.php';
if (!check_alreadyLoggedIn($con)) {
    header("Location: ../user/login.php");
    exit;
}

try {
    $valuesToSelect = ["nome", "cognome", "email", "telefono", "indirizzo", "eta"];
    $row = genericSelect("users", $valuesToSelect, "email=?", [$_SESSION["email"]], $con);
} catch (Exception $e) {
    $_SESSION["error_message"] = "Qualcosa è andato storto...Riprova pià tardi";
    header("Location: ../structure/index.php");
    error_log("Failed to search user data from the database: " . $e->getMessage() . "\n", 3, "error.log");
}
?>

<div class="container">
    <div class="profile">
        <div class="profile_image"></div>
        <div class="profile_info">
            <!-- FORM -->
            <form action="update_profile.php" method="post" id="updateProfile" novalidate>
                <input hidden type="text" id="sectionTitle" value="Profilo">
                <!-- COLONNE -->
                <div class="columns">
                    <div class="col1">
                        <div class="input-control2">
                            <label for="firstname">Nome:</label>
                            <input type="text" id="firstname" name="firstname" value=<?php echo htmlspecialchars($row["nome"]) ?>>
                        </div>

                        <div class="input-control2">
                            <label for="email" class="label">Email:</label>
                            <input type="email" id="email" name="email" value=<?php echo htmlspecialchars($row["email"]) ?>>
                        </div>

                        <div class="input-control2">
                            <label for="address" class="label">Indirizzo:</label>
                            <input type="text" id="address" name="address" value=<?php echo isset($row["indirizzo"]) ? htmlspecialchars($row["indirizzo"]) : null ?>>
                        </div>

                        <div class="input-control2 pass">
                            <label for="pass">Nuova password:</label>
                            <input type="password" id="pass" name="pass">
                        </div>
                    </div>

                    <div class="col2">
                        <div class="input-control2">
                            <label for="lastname" class="label">Cognome:</label>
                            <input type="text" id="lastname" name="lastname" value=<?php echo htmlspecialchars($row["cognome"]) ?>>
                        </div>

                        <div class="input-control2">
                            <label for="phone" class="label">Telefono:</label>
                            <input type="text" id="phone" name="phone" value=<?php echo isset($row["telefono"]) ? htmlspecialchars($row["telefono"]) : null ?>>
                        </div>

                        <div class="input-control2">
                            <label for="age" class="age">Età:</label>
                            <input type="text" id="age" name="age" value=<?php echo isset($row["eta"]) ? htmlspecialchars($row["eta"]) : null ?>>
                        </div>

                        <div class="input-control2 pass">
                            <label for="confirm">Conferma password:</label>
                            <input type="password" id="confirm" name="confirm">
                        </div>
                    </div>
                </div>
                <div id="editPass"> <a href=""> Aggiorna password </a></div>
                <button id="submit_button_profile" type="submit">Update</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById("editPass").addEventListener("click", function(e) {
        e.preventDefault();
        let elements = document.getElementsByClassName("input-control2");
        for (let i = 0; i < elements.length; i++) {
            if (elements[i].classList.contains("pass"))
                elements[i].style.display = 'block';
            else {
                elements[i].style.display = 'none';
                elements[i].getElementsByTagName("input")[0].removeAttribute("value");
            }
        }
        document.getElementById("editPass").remove();
        if (document.getElementById("message")) {
            document.getElementById("message").remove();
        }
    });
</script>

<script defer src="../../js/validateInput.js"></script>