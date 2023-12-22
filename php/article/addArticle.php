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

<script src="../../js/addArticle.js"></script>

<?php
require_once "../structure/footer.php";
?>