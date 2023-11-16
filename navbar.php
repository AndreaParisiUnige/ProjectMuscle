<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php
        if (!isset($_SESSION["logged_in"])) {
            echo '<li><a href="registration.php">Sign-up</a></li>';
            echo '<li><a href="login.php">Sign-in</a></li>';
        }
        else {
            if($_SESSION["admin"]==1)
                echo '<li><a href="allusers.php">Show all users</a></li>';
            echo '<li><a href="profile.php">Show profile</a></li>';
            echo '<li><a href="logout.php">Logout</a></li>';
        }
        ?>
    </ul>
</nav>