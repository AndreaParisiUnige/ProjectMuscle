document.querySelector('#searchInput').addEventListener("keyup", function() {
    let value = this.value.toLowerCase();
    let articles = document.querySelectorAll(".articleLink");

    articles.forEach(function(article) {
        let articleText = article.querySelector('.articlePreview').textContent.toLowerCase();
        let articleContainsValue = articleText.includes(value);
        if (value === '') {
            article.style.display = "block"; // Mostra tutti gli articoli se il campo di ricerca è vuoto
        } else if (!articleContainsValue) {
            article.style.display = "none"; // Nascondi l'articolo se non contiene il titolo cercato
        } else {
            article.style.display = "block"; // Mostra l'articolo se contiene il titolo cercato
        }
    });
});