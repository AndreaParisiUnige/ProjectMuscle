const ErrorMessages = {
    EMPTY_FIELD: 'Campo obbligatorio',
    PASSWORD_MISMATCH: 'Le password non corrispondono',
    INVALID_EMAIL: 'Email non valida',
    ALREADY_EXISTS: 'Email già registrata'
};

const BorderColor = {
    ERROR : '2px solid #a50727',
    SUCCESS : '2px solid green',
    NONE : 'none'
}

function setBorderColor(node, color) {
    node.style.border = color;
}

function isValidEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

// Crea e ritorna un div contenente il messaggio di errore, con classe errorDiv e id elementoId-error
function createErrorNode(element, message, errorId) {
    let errorNode = document.createElement('div');
    errorNode.innerText = message;
    errorNode.setAttribute('class', 'errorDiv');
    errorNode.setAttribute('id', `${element}${errorId}-error`);
    return errorNode;
}

// Ritorna un oggetto contenente i nodi degli errori se presenti
function checkErrorNodes(element) {
    return {
        emptyFieldError: document.getElementById(`${element}-error`),
        passNotMatchError: element === 'confirm' ? document.getElementById('confirmNotMatch-error') : null,
        emailNotValidError: element === 'email' ? document.getElementById('emailNotValid-error') : null,
        existingEmailError: element === 'email' ? document.getElementById('emailAlreadyExist-error') : null
    };
}

// Gestisce gli errori:
// addError=true: aggiunge l'errore --> se setErrorBorder=true imposta bordo rosso
// addError=false: rimuove l'errore --> se setErrorBorder=null elimina bordo, se setErrorBorder=true imposta bordo verde, 
function toggleError(fieldNode, errorNode, addError, setBorder) {
    if (addError) {
        if (setBorder)
            setBorderColor(fieldNode, BorderColor.ERROR);
        fieldNode.insertAdjacentElement('afterend', errorNode);
    } else {
        if(setBorder === null)
            setBorderColor(fieldNode, BorderColor.NONE);
        else if (setBorder)
            setBorderColor(fieldNode, BorderColor.SUCCESS);
        if (errorNode)
            errorNode.remove();
    }
}

function conditionalAddError(e, condition, fieldNode, existingErrorNode, setErrorBorder, errorMessage, errorId) {
    if (fieldNode.id === 'confirm') {
        var pass = document.getElementById('pass').value.trim();
    }
    if (eval(condition)) { 
        e.preventDefault();
        if (!existingErrorNode) {
            let newErrorNode = createErrorNode(fieldNode.id, errorMessage, errorId);
            toggleError(fieldNode, newErrorNode, true, setErrorBorder);                  
        }
        return true;
    }
}

function checkEmptyField(e, fieldNode) {
    let { emptyFieldError, passNotMatchError, emailNotValidError, existingEmailError } = checkErrorNodes(fieldNode.id);
    let hasError = passNotMatchError || emailNotValidError || existingEmailError;

    if (conditionalAddError(e, "fieldNode.value.trim() === ''", fieldNode, emptyFieldError, true, ErrorMessages.EMPTY_FIELD, ''))   // Campo vuoto, aggiungo errore e bordo rosso
        return true; 
    else if (hasError)                                                                     // Se sono presenti errori sul nodo mi limito a togliere il messaggio EMPTY_FIELD
        toggleError(fieldNode, emptyFieldError, false, false);   
    else 
        toggleError(fieldNode, emptyFieldError, false, true);
}

function checkEmptyFields(e, ...params) {
    params.forEach(element => {
        var fieldNode = document.getElementById(element);
        checkEmptyField(e, fieldNode);
    });
}

function checkMatchingPass(e, fieldNode) {
    let { emptyFieldError, passNotMatchError, emailNotValidError, existingEmailError } = checkErrorNodes(fieldNode.id);
    if (!conditionalAddError(e, "fieldNode.value.trim() != pass", fieldNode, passNotMatchError, true, ErrorMessages.PASSWORD_MISMATCH, 'NotMatch')){ // Password non corrispondenti
        if (passNotMatchError)
            toggleError(fieldNode, passNotMatchError, false, emptyFieldError ? false : true);
    } 
}

function checkValidEmail(e, fieldNode) {
    let { emptyFieldError, passNotMatchError, emailNotValidError, existingEmailError } = checkErrorNodes(fieldNode.id);
    if(!conditionalAddError(e, "!isValidEmail(fieldNode.value.trim())", fieldNode, emailNotValidError, true, ErrorMessages.INVALID_EMAIL, 'NotValid')){
        if (existingEmailError || emptyFieldError)
            toggleError(fieldNode, emailNotValidError, false, false);  
        else if (emailNotValidError)
            toggleError(fieldNode, emailNotValidError, false, true);    
    }   
}

async function checkExistingEmail(){
    let { emptyFieldError, passNotMatchError, emailNotValidError, existingEmailError } = checkErrorNodes('email');
    hasError = emptyFieldError ||  emailNotValidError;

    let emailNode = document.getElementById('email');
    let emailVal = emailNode.value.trim();
    if (isValidEmail(emailVal)) {
        return fetch('checkExistingEmail.php', {
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
                if (!existingEmailError) {
                    errorNodeEmail = createErrorNode('email', ErrorMessages.ALREADY_EXISTS, 'AlreadyExist');
                    toggleError(emailNode, errorNodeEmail, true, true);                    
                }              
                return true;
            }
            else if (!hasError)
                toggleError(emailNode, existingEmailError, false, true);
        })
        .catch(error => {
            console.log(error);
        });
    }
    else if (existingEmailError)
        toggleError(emailNode, existingEmailError, false, !hasError? null : false);
}

function validateInputs(e, ...params) {
    params.forEach(element => {
        var fieldNode = document.getElementById(element);
        if(!checkEmptyField(e, fieldNode)){
            if (element === 'email') {
                checkValidEmail(e, fieldNode);
            }
            if (element === 'confirm')
                checkMatchingPass(e, fieldNode);
        }
    });
}


const path = window.location.pathname;
const pageName = path.split('/').pop();
let exist = false;

document.querySelector('form').addEventListener('input', async function (e) {
    if (pageName === 'registration.php') {
        validateInputs(e, 'firstname', 'lastname', 'email', 'pass', 'confirm');    
        if (e.target && e.target.matches('input[type="email"]')) 
            exist = await checkExistingEmail();
    }
});

document.querySelector('form').addEventListener('submit', function (e) {
    if (pageName === 'registration.php') {
        if (exist)
            e.preventDefault();
        validateInputs(e, 'firstname', 'lastname', 'email', 'pass', 'confirm'); 
    }
    else if (pageName === 'login.php')
        validateInputs(e, 'email', 'pass');
});