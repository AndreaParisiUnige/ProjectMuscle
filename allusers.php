<?php
session_start();
require_once 'header.php';
require_once 'navbar.php';

checkSessionError();
checkSessionMessage();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true && isset($_SESSION["admin"]) && $_SESSION["admin"] === 1) {
    $query = "SELECT id, nome, cognome, email, admin FROM users"; // Prepared statement is not needed here

    try {
        $res = mysqli_query($con, $query);
    } catch (Exception $e) {
        echo "<p>Errore: impossibile accedere ai dati</p>";
        error_log("Failed to access data: " . $e->getMessage() . "\n", 3, "error.log");
        exit;
    }

    if ($res) {
        if (mysqli_num_rows($res) > 1) {
            while ($row = mysqli_fetch_assoc($res)) {
                if ($row["admin"] == 0) {
                    echo "<p>" . htmlspecialchars($row["nome"]) . " " . htmlspecialchars($row["cognome"]) . " " . htmlspecialchars($row["email"]);
                    echo "<form method='post' action='deleteUser.php'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<button type='submit'>X</button>";
                    echo "</form></p>";
                }
            }
        } else
            $_SESSION['error_message'] = "Non ci sono utenti registrati";
        mysqli_free_result($res);
    } else {
        $_SESSION['error_message'] = "Errore: si prega di riprovare più tardi";
        error_log("Failed to access data: " . mysqli_error($con) . "\n", 3, "error.log");
        mysqli_close($con);
        reloadPage();
    }
    mysqli_close($con);
} else {
    header("Location: login.php");
    exit;
}
?>

<?php
require_once 'footer.php';
?>
