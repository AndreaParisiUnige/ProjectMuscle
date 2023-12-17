<main>
    <div class="container">
        <img src="curl.jpeg" alt="curl" style="width:100%">
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
        $articles = genericSelect("articoli", ['*'], NULL, NULL, $con); 
        if (isset($articles)) {
            if (is_array($articles) && !is_array($articles[0])) {   // Caso in cui la select ha restituito un singolo elemento
                $articles = [$articles]; 
            }
            foreach ($articles as $article) {
                $article['title'] = preg_replace('/<h([1-6])([^>]*)>/', '<h3$2>', $article['title']);
                echo
                "<a href=\"article.php?id=" . $article['articleNum'] . "\">
                    <div class=\"articlePreview\">" .
                    "<div class=\"articleTitle\">" . $article['title'] . "</div>" .
                    $article['article'] .
                    "</div></a>";
            }
        }
        ?>
    </section>
</main>

<script>
    document.querySelector('#searchInput').addEventListener("keyup", function() {
        let value = this.value.toLowerCase();
        let articles = document.querySelectorAll(".articlePreview");

        articles.forEach(function(article) {
            let articleText = article.querySelector('.articleTitle').textContent.toLowerCase();
            let articleContainsValue = articleText.includes(value);
            if (value === '') {
                article.parentElement.style.display = "block"; // Mostra tutti gli articoli se il campo di ricerca è vuoto
            } else if (!articleContainsValue) {
                article.parentElement.style.display = "none"; // Nascondi l'articolo se non contiene il testo cercato
            } else {
                article.parentElement.style.display = "block"; // Mostra l'articolo se contiene il testo cercato
            }
        });
    });
</script>
