function deleteArticle(articleId) {
    if (confirm("Sei sicuro di voler eliminare questo articolo?")) {
        $.post("../article/deleteArticle.php", { id: articleId })
            .done(function () {
                window.location.href = '../structure/index.php';
                alert("Articolo eliminato con successo!");
            })
            .fail(function () {
                alert("Non è possibile eliminare l'articolo");
            });
    }
}
