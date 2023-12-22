$(document).ready(function() {
    var savedData = localStorage.getItem('articleData');
    if (savedData)      // Per update, necessario articleNum e request, il contenuto dell'editor viene inizializzato automaticamente
        var articleData = JSON.parse(savedData);
    let form = document.getElementById("getDataForm");

    form.addEventListener("submit", function(e) {
        e.preventDefault();
        let content = tinymce.get("textarea").getContent();

        let parser = new DOMParser();
        let doc = parser.parseFromString(content, 'text/html');
        let title = doc.body.firstChild;    // Per controllare formattazione del titolo

        if (title && title.nodeName.toLowerCase().startsWith('h')) {
            let contentHtml = doc.body.innerHTML;             // Corpo dell'articolo
            let titleHtml = title.outerHTML.trim();           // Titolo dell'articolo
            contentHtml = contentHtml.replace(titleHtml, ''); // Rimozione del titolo dal corpo dell'articolo

            let dataToSend = {
                title: titleHtml,
                content: contentHtml,
            };
            if (savedData) {
                dataToSend.articleNum = articleData.articleNum;
                dataToSend.request = articleData.request;
            } else {
                dataToSend.request = 'add';
            }
            $.post('addArticleLogic.php', dataToSend) 
                .done(function() {
                    alert("Articolo inserito con successo!");
                    if (savedData){
                        window.location.href = '../article/article.php?id='+dataToSend.articleNum;
                        localStorage.removeItem('articleData');
                    }                  
                })
                .fail(function() {
                    alert("C'è stato un errore durante l'inserimento dell'articolo, riprovare più tardi");
                });
            tinymce.get("textarea").setContent('');
        }
    });
});