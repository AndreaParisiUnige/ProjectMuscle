<?php
ob_start();
session_start();
require_once '../utility/query.php';
set_error_handler("errorHandler");
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <title>Project muscle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/beercss@3.4.7/dist/cdn/beer.min.css" rel="stylesheet">
    <script type="module" src="https://cdn.jsdelivr.net/npm/beercss@3.4.7/dist/cdn/beer.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/material-dynamic-colors@1.1.0/dist/cdn/material-dynamic-colors.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../css/stile.css">
    <link rel="stylesheet" type="text/css" href="../../css/form_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@800&display=swap" rel="stylesheet">
</head>

<body>
    <header class="fixed">
        <nav>
            <img src="../../images/projectMuscle_logo.png" alt="Logo project muscle">
            <div>
                <ul>
                    <li><a href="../structure/index.php">Home</a></li>
                    <?php                   
                    ifCookieSetSessionParams($con);
                    if (isset($_SESSION["logged_in"])) {
                        if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
                            echo '<li><a href="../user/allusers.php">Gestione utenti</a></li>';
                            echo '<li><a href="../article/addArticle.php">Aggiungi articolo</a></li>';
                        }
                        echo '<li><a href="../user/logout.php">Logout</a></li>';
                    } else {
                        echo '<li><a href="../user/registration.php">Registrazione</a></li>';
                        echo '<li><a href="../user/login.php">Login</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <div class="searchZone">
                <div class="field small prefix round fill" id="searchBar">
                    <i class="front">search</i>
                    <input type=text id="searchInput" placeholder="Cerca nel sito...">
                </div>
                <?php
                echo
                '<a href="../user/show_profile.php">
                <i class="large" id="accountCircle">account_circle</i>
                </a>';
                ?>
            </div>
        </nav>
    </header>

    <div class="dynamicNav" id="dynamicNav">
        <h1 id="header_content"></h1>
    </div>

    <div style="font-size: 16px;">
        <?php
        checkSessionError();
        checkSessionMessage();
        ?>
    </div>

    <script src="../../js/manageHeader.js" defer></script>