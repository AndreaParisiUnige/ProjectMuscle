var pathPage = window.location.pathname;
var page = pathPage.split('/').pop();

addEventListener("DOMContentLoaded", function () {
    if (page == "index.php" || page == "") {
        let elem = document.getElementById("dynamicNav");
        if (elem !== null) {
            elem.remove();
        } else {
            console.log("L'elemento con ID 'dynamicNav' non è stato trovato.");
        }
    }

    else {
        let pageTitle = document.getElementById("sectionTitle");
        let header = document.getElementById("header_content");
        if (pageTitle !== null && header !== null) {
            header.innerText = pageTitle.value;
        } else {
            console.log("L'elemento con ID 'dynamicNav' non è stato trovato.");
        }
    }
});