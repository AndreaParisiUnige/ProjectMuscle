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
        foreach ($articles as $article) {
            $article['title'] = preg_replace('/<h([1-6])([^>]*)>/', '<h3$2>', $article['title']);
            echo 
                "<a href=\"article.php?id=" . $article['articleNum'] . "\">
                <div class=\"articlePreview\">" .
                "<div class=\"articleTitle\">" . $article['title'] . "</div>" . 
                $article['article'] .
                "</div></a>";
        }
        ?>
    </section>
</main>

