<?php
require_once "../structure/header.php";
exitIfNotAdmin($con);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<script>    alert('ciao');</script>";
    $title = $_POST['title'];
    echo ($content = $_POST['content']);
    echo ($articleNum = $_POST['articleNum']);
    echo "<script>    var title = `<?php echo $title; ?>`;
            var content = `<?php echo $content; ?>`;
            tinymce.get(\"textarea\").setContent(title + content);</script>";
    echo "<input type=\"hidden\" name=\"request\" id=\"request\" value=\"update\">";
    if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['request']) && isset($_POST['articleNum'])) {

        if ($_POST['request'] === 'add') {
            try {
                if (insert_data("articoli", ["articleNum" => "NULL", "title" => $title, "article" => $content], $con))
                    http_response_code(200);    // OK
                else
                    http_response_code(500);    // Errore interno al server 
            } catch (Exception $e) {
                error_log("Failed to insert data into the database: " . $e->getMessage() . "\n", 3, "error.log");
                http_response_code(500);
            }
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    http_response_code(405);   // Metodo non consentito
}
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
                    request: 'add'
                };
                $.post('modArticle.php', dataToSend) // Richiesta AJAX
                    .done(function() {
                        alert("Articolo inserito con successo!");
                    })
                    .fail(function() {
                        alert("C'è stato un errore durante l'inserimento dell'articolo, riprovare più tardi");
                    });
                

            }
            var savedData = localStorage.getItem('articleData');

                if (savedData) {
                    var articleData = JSON.parse(savedData);

                    tinymce.get("textarea").setContent(articleData.title + articleData.content);
                }
        });
    });
</script>

<?php
require_once "../structure/footer.php";
?>