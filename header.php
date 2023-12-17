<?php
session_start();
require_once 'utils.php';
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

    
    <link rel="stylesheet" type="text/css" href="stile.css">
    <link rel="stylesheet" type="text/css" href="form_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@800&display=swap" rel="stylesheet">
</head>

<body>


    <header class="fixed">
        <?php
        require_once 'navbar.php';
        ?>
    </header>

    <div class="dynamicNav" id="dynamicNav">
        <h1 id="header_content"></h1>
    </div>

    <script src="js/manageHeader.js" defer></script>