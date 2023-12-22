// Prende tutti i campi del profilo per nasconderli nel caso si voglia aggiornare la password,
// svuotandoli dai valori predefiniti all'evenienza

document.getElementById("editPass").addEventListener("click", function(e) {
    e.preventDefault();
    let elements = document.getElementsByClassName("input-control2");   
    for (let i = 0; i < elements.length; i++) {
        if (elements[i].classList.contains("pass"))
            elements[i].style.display = 'block';
        else {
            elements[i].style.display = 'none';
            elements[i].getElementsByTagName("input")[0].removeAttribute("value");
        }
    }
    document.getElementById("editPass").remove();
    if (document.getElementById("message")) {
        document.getElementById("message").remove();
    }
});