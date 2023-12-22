<?php
require_once "../structure/header.php";
exitIfNotAdmin($con);
?>

<script src="https://cdn.tiny.cloud/1/f2g36280gpqhu8xldrdcbuuenjw5jljdxuhg1bosjhmsxm97/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="../../js/init-tinymce.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form method="post" id="getDataForm">
    <input hidden type="text" id="sectionTitle" value="Editor">
    <textarea id="textarea"></textarea>
    <button type="submit" id="submit_button">Submit</button>
</form>

<script>
    $(document).ready(function() {
        // If present, load the article data from the localStorage
        var savedData = localStorage.getItem('articleData');
        if (savedData) 
            var articleData = JSON.parse(savedData);

        let form = document.getElementById("getDataForm");
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            let content = tinymce.get("textarea").getContent();

            let parser = new DOMParser();
            let doc = parser.parseFromString(content, 'text/html');
            let title = doc.body.firstChild;

            if (title && title.nodeName.toLowerCase().startsWith('h')) {
                let contentHtml = doc.body.innerHTML;
                let titleHtml = title.outerHTML.trim();
                contentHtml = contentHtml.replace(titleHtml, '');

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
                $.post('addArticleLogic.php', dataToSend) // Richiesta AJAX
                    .done(function() {
                        alert("Articolo inserito con successo!");
                    })
                    .fail(function() {
                        alert("C'è stato un errore durante l'inserimento dell'articolo, riprovare più tardi");
                    });
                tinymce.get("textarea").setContent('');
            }
        });
    });
</script>

<?php
require_once "../structure/footer.php";
?>