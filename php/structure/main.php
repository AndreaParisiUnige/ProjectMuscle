<main>
    <div class="container">
        <img src="../../images/curl.jpeg" alt="curl" style="width:100%">
        <div class="image-text">
            <h1 class="center-align">Articoli e Guide</h1>
            <p>Scopri come costruire muscoli, bruciare grasso e rimanere motivato.
                Queste guide ti insegneranno come raggiungere i tuoi obiettivi di salute e forma
                fisica.
            <p>
        </div>
    </div>

    <section class="articlesContainer">
        <?php
        try {
            $articles = genericSelect("articoli", ['*'], NULL, NULL, $con);
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Non è stato possibile recuperare gli articoli. Riprova più tardi.";
            error_log("Failed to retrieve articles: " . $e->getMessage() . "\n", 3, "error.log");
        }

        if (isset($articles)) {
            if (is_array($articles) && !is_array($articles[0])) {   // Caso in cui la select ha restituito una singola row
                $articles = [$articles];
            }
            // Validazione output non necessaria, TinyMCE si occupa di filtrare l'input
            foreach ($articles as $article) {
                $article['title'] = preg_replace('/<h([1-6])([^>]*)>/', '<h3$2>', $article['title']);
                echo
                "<a class=\"articleLink\" href=\"../article/article.php?id=" . $article['articleNum'] . "\">
                    <div class=\"articlePreview\">" .
                    "<div class=\"articleTitle\">" . $article['title'] . "</div>" .
                    $article['article'] .
                    "</div></a>";
            }
        } else {
            $_SESSION["error_message"] = "Non è presente alcun articolo al momento...";
        }
        ?>
    </section>
</main>

<script src="../../js/manageArticles.js"> </script>