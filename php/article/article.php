<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../js/modifyArticle.js"></script>

<?php
require_once "../structure/header.php";

if (isset($_GET['id'])) {
    $articleId = $_GET['id'];
    if ($article = genericSelect("articoli", ['title', 'article'], "articleNum=?", [$articleId], $con)) {
        $title = $article['title'];
        $content = $article['article'];

        echo
        "<div class=\"article\">" .
            "<input hidden type=\"text\" id=\"sectionTitle\" value=\"" . $title . "\">" .
            "<div class=\"articleText\">" . $content . "</div>";
        if (check_admin($con)) {
            echo "<div id='manageArticleButtons'><button class=\"responsive\" id=\"deleteArticle\" onclick=\"deleteArticle('" . $articleId . "')\">Delete</button>";
            echo "<button class=\"responsive\" id=\"updateArticle\">Update</button></div>";
        };

        require_once "../article/comment.php";
        echo "</div>";
    }
} else {
    $_SESSION["error_message"] = "Impossibile caricare correttamente la pagina.";
}
require_once "../structure/footer.php";
?>

<script>
    $(document).ready(function() {
        $('#updateArticle').click(function() {
            var articleId = <?php echo $articleId; ?>;
            var title = `<?php echo $title; ?>`;
            var content = `<?php echo $content; ?>`;

            var dataToSend = {
                articleNum: articleId,
                title: title,
                content: content,
                request: 'update'
            };

            localStorage.setItem('articleData', JSON.stringify(dataToSend));
            window.location.href = "../article/addArticle.php?";
        });
    });
</script>