function updateArticle(articleId, title, content) {
    $('#updateArticle').click(function() {
        let dataToSend = {
            articleNum: articleId,
            title: title,
            content: content,
            request: 'update'
        };
        localStorage.setItem('articleData', JSON.stringify(dataToSend));    // Verranno recuperati per effettuare la modifica in addArticle.php
        window.location.href = "../article/addArticle.php?";
    });
}

function deleteArticle(articleId) {
    $('#deleteArticle').click(function() {
        if (confirm("Sei sicuro di voler eliminare questo articolo?")) {
            let dataToSend = {
                id : articleId,
                table: "articoli",
                idName: "articleNum"
            };
            $.post("../article/delete.php", dataToSend)
                .done(function() {
                    window.location.href = '../structure/index.php';
                    alert("Articolo eliminato con successo!");
                })
                .fail(function() {
                    alert("Non è possibile eliminare l'articolo");
                });
        }
    });
}
  
