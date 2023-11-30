const ErrorMessages = {
    EMPTY_FIELD: 'Campo obbligatorio',
    PASSWORD_MISMATCH: 'Le password non corrispondono',
    INVALID_EMAIL: 'Email non valida',
    ALREADY_EXISTS: 'Email già registrata'
};

function isValidEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function createErrorNode(element, message, errorId) {
    var errorNode = document.createElement('div');
    errorNode.innerText = message;
    errorNode.setAttribute('class', 'errorDiv');
    errorNode.setAttribute('id', `${element}${errorId}-error`);
    return errorNode;
}


function toggleError(fieldNode, errorNode, addError, existingError) {
    if (addError) {
        fieldNode.style.border = '2px solid #a50727';
        fieldNode.insertAdjacentElement('afterend', errorNode);
    } else {
        if (!existingError)
            fieldNode.style.border = '2px solid green';
        if (errorNode)
            errorNode.remove();
    }
}


function validateInputs(e, ...params) {
    var passMatchErrorNode = document.getElementById('confirmNotMatch-error');
    var emailNotValid = document.getElementById(`emailNotValid-error`);

    params.forEach(element => {
        var fieldNode = document.getElementById(element);
        var fieldValue = fieldNode.value.trim();

        var emptyFieldErrorNode = document.getElementById(`${element}-error`);

        if (fieldValue === '') {
            e.preventDefault();
            if (!emptyFieldErrorNode) {
                var errorNodeEmpty = createErrorNode(element, ErrorMessages.EMPTY_FIELD, '');
                toggleError(fieldNode, errorNodeEmpty, true, null);                     // Campo vuoto, aggiungo errore e bordo rosso
            }
        }
        else if (emptyFieldErrorNode && passMatchErrorNode && element === 'confirm')   // Errore di password mismatch e di campo vuoto da submit precedente
            toggleError(fieldNode, emptyFieldErrorNode, false, true);                   // Non imposto il bordo verde essendo presente l'errore di password mismatch
        else if (emptyFieldErrorNode && !emailNotValid)                                                   // Bordo verde: pass mismatch non presente e campo pieno
            toggleError(fieldNode, emptyFieldErrorNode, false, false);
        else if ((fieldValue !== '' && element !== 'confirm' && element !== 'email') || (!passMatchErrorNode && element === 'confirm'))  // Campo pieno e non è confirm, oppure è confirm e non c'è errore di password mismatch
            fieldNode.style.border = '2px solid green';

        if (element === 'confirm') {
            emptyFieldErrorNode = document.getElementById(`${element}-error`);
            var pass = document.getElementById('pass').value.trim();
            if (pass != fieldValue) {
                e.preventDefault();
                if (!passMatchErrorNode) {
                    var errorNodePass = createErrorNode('confirm', ErrorMessages.PASSWORD_MISMATCH, 'NotMatch');
                    toggleError(fieldNode, errorNodePass, true, null);
                }
            }
            else if (passMatchErrorNode && emptyFieldErrorNode)
                toggleError(fieldNode, passMatchErrorNode, false, true);
            else if (passMatchErrorNode && !emptyFieldErrorNode)
                toggleError(fieldNode, passMatchErrorNode, false, false);
        }

        if (element == 'email') {
            var emailNotValid = document.getElementById(`emailNotValid-error`);
            emptyFieldErrorNode = document.getElementById(`${element}-error`);

            if (!emptyFieldErrorNode) {
                if (!isValidEmail(fieldValue)) {
                    e.preventDefault();
                    if (!emailNotValid) {
                        var errorNodeEmail = createErrorNode('email', ErrorMessages.INVALID_EMAIL, 'NotValid');
                        toggleError(fieldNode, errorNodeEmail, true, null);
                    }
                }
                else
                    toggleError(fieldNode, emailNotValid, false, false);
            }
        }
    });
}


const path = window.location.pathname;
const pageName = path.split('/').pop();

document.querySelector('form').addEventListener('submit', function (e) {
    if (pageName === 'registration.php')
        validateInputs(e, 'firstname', 'lastname', 'email', 'pass', 'confirm');
    else if (pageName === 'login.php')
        validateInputs(e, 'email', 'pass');
});

if (pageName === 'registration.php') {
    document.querySelector('input[type="email"]').addEventListener('input', function (e) {
        var emailError = document.getElementById('emailAlreadyExist-error');
        var emailNode = document.getElementById('email');
        var emailVal = emailNode.value.trim();
        if (isValidEmail(emailVal)) {
            fetch('checkExistingEmail.php', {
                method: 'POST',
                headers: { "Content-type": "application/x-www-form-urlencoded" },
                body: `email=${emailVal}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Errore nella richiesta');
                }
                return response.json();
            })
            .then(data => {
                if (data.existing_User) {
                    if (!emailError)
                        errorNodeEmail = createErrorNode('email', ErrorMessages.ALREADY_EXISTS, 'AlreadyExist');
                        toggleError(emailNode, errorNodeEmail, true, null); 
                }
                else
                    toggleError(emailNode, emailError, false, false);
            })
            .catch(error => {
                console.log(error);
            });
        }
        else if (emailError || !isValidEmail(emailVal)) {
            toggleError(emailNode, emailError, false, false);
            emailNode.style.border = 'none';
        }
        
    });
}