const ErrorMessages = {
    EMPTY_FIELD: 'Campo obbligatorio',
    PASSWORD_MISMATCH: 'Le password non corrispondono'
};

function createErrorNode(element, message, errorClass, errorId) {
    var errorNode = document.createElement('div');
    errorNode.innerText = message;
    errorNode.setAttribute('class', errorClass);
    errorNode.setAttribute('id', `${element}${errorId}-error`);
    return errorNode;
}

function toggleError(fieldNode, errorNode, addError) {
    if (addError) {
        fieldNode.style.border = '2px solid red';
        fieldNode.insertAdjacentElement('afterend', errorNode);
    } else {
        fieldNode.style.border = '';
        if (errorNode) {
            errorNode.remove();
        }
    }
}

function emptyParams(e, ...params) {
    var empty = false;

    params.forEach(element => {
        var fieldNode = document.getElementById(element);
        var fieldValue = fieldNode.value.trim();
        var emptyFieldErrorNode = document.getElementById(`${element}-error`);

        if (fieldValue === '') {
            e.preventDefault();
            if (!emptyFieldErrorNode) {
                var errorNode = createErrorNode( element, ErrorMessages.EMPTY_FIELD, 'emptyField', '');
                toggleError(fieldNode, errorNode, true);
                empty = true;
            }
        } else if (emptyFieldErrorNode) 
            toggleError(fieldNode, emptyFieldErrorNode, false);
    });
    return empty;
}

function correspondingPass(e) {
    var pass = document.getElementById('pass').value.trim();
    var confirmNode = document.getElementById('confirm');
    var confirm = confirmNode.value.trim();
    var passMatchErrorNode = document.getElementById('confirmNotMatch-error');

    if (pass !== confirm) {
        e.preventDefault();
        if (!passMatchErrorNode) {
            var errorNode = createErrorNode('confirm', ErrorMessages.PASSWORD_MISMATCH, 'wrongPass', 'NotMatch');
            toggleError(confirmNode, errorNode, true);
        }
    } else if (passMatchErrorNode) 
        toggleError(confirmNode, passMatchErrorNode, false);
}




const path = window.location.pathname;
const pageName = path.split('/').pop();

document.querySelector('form').addEventListener('submit', function (e) {
    if (pageName === 'registration.php') {
        if (!emptyParams(e, 'firstname', 'lastname', 'email', 'pass', 'confirm')) {
            correspondingPass(e);
        }
    } else if (pageName === 'login.php') {
        emptyParams(e, 'email', 'pass');
    }
});