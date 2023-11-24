<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php
        require_once 'connection.php';
        require_once 'query.php';

        if (isset($_SESSION["logged_in"]) || isset($_COOKIE["token"]) && checkValideCookie($_COOKIE["token"], $con)) {
            if(isset($_SESSION["admin"]) && $_SESSION["admin"]==1)
                echo '<li><a href="allusers.php">Show all users</a></li>';
            echo '<li><a href="profile.php">Show profile</a></li>';
            echo '<li><a href="reserved.php">Reserved</a></li>';
            echo '<li><a href="logout.php">Logout</a></li>';
        }
        else {
            echo '<li><a href="registration.php">Sign-up</a></li>';
            echo '<li><a href="login.php">Sign-in</a></li>';
        }
        
        ?>
    </ul>
</nav>