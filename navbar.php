<nav>
    <img src="logo2.png" alt="Logo project muscle">
    <div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php
            require_once 'connection.php';
            require_once 'query.php';

            if (isset($_COOKIE["token"])) {
                if ($row = genericSelect("users", SELECT_COOKIE, WHERE_STMT_COOKIE, [$_COOKIE["token"]], $con))
                    setSessionParams($row);
            }
            if (isset($_SESSION["logged_in"])) {
                if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
                    echo '<li><a href="allusers.php">Gestione utenti</a></li>';
                    echo '<li><a href="addArticle.php">Aggiungi articolo</a></li>';
                }                 
                echo '<li><a href="reserved.php">Reserved</a></li>';
                echo '<li><a href="logout.php">Logout</a></li>';
            } else {
                echo '<li><a href="registration.php">Sign-up</a></li>';
                echo '<li><a href="login.php">Sign-in</a></li>';
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
                '<a href="show_profile.php">
                <i class="large" id="accountCircle">account_circle</i>
                </a>';
        ?>
    </div>
</nav>