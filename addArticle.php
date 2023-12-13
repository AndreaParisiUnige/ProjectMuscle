<?php
ob_start();
require_once "header.php";
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true && isset($_SESSION["admin"]) && $_SESSION["admin"] === 1) {}
else {
    header("Location: index.php");
    exit();
}
?>

<script src="https://cdn.tiny.cloud/1/f2g36280gpqhu8xldrdcbuuenjw5jljdxuhg1bosjhmsxm97/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="js/init-tinymce.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form method="post" id="getDataForm" >
    <input hidden type="text" id="sectionTitle" value="Editor">
    <textarea id="textarea" class = "elemento-senza-stile-beer"></textarea>
    <button type="submit" id="submit">Submit</button>
</form>

<script>
addEventListener("DOMContentLoaded", function(e){

        let form = document.getElementById("getDataForm");
        form.addEventListener("submit", function(e){
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
                    content: contentHtml
                };
                $.post('addArticle.php', dataToSend, function(response) {
                    
                });
            }
        });
    });
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['content'])) {
    $title = $_POST['title']; 
    $content = $_POST['content'];
    insert_data("articoli", ["articleNum" => "NULL", "title" => $title, "article" => $content], $con);

    $_SESSION["message"] = "Articolo inserito con successo!";
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION["error_message"] = "C'è stato un errore durante l'inserimento dell'articolo, riprovare più tardi";
}
require_once "footer.php" ;
?>

