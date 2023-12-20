<?php
    require_once "../structure/header.php";
    if(isset($_GET['id'])) {
        $article = genericSelect("articoli", ['title' , 'article'], "articleNum=?", [$_GET['id']], $con);
        echo "<div class=\"article\">" .
        "<input hidden type=\"text\" id=\"sectionTitle\" value=\"" . $article ['title'] . "\">" .
        "<div class=\"articleText\">" . $article ['article'] . "</div>" ;
        require_once "../article/comment.php";
        echo "</div>";
        

    } else {
        $_SESSION["error_message"] = "Impossibile caricare correttamente la pagina.";
    }
    require_once "../structure/footer.php";
?>