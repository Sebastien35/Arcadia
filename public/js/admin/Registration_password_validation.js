const registrationForm = document.querySelector('#registrationForm');
const submitButton = document.querySelector('#registerNewUserBtn');

const emailInput = document.querySelector('#email');
const roleInput=document.querySelector('#Roles');
const PasswordInput = document.querySelector('#password');
const ConfirmPasswordInput = document.querySelector('#confirmPassword');


document.addEventListener('DOMContentLoaded', validateEmail);

document.addEventListener('DOMContentLoaded', () => {
    validateEmail();
    validateRole();
    CheckForm(); // Ensure the form is validated on page load
});

PasswordInput.addEventListener('input', () => {
    MdpOk
    passwordMatching
    verificationMotDePasse
});

ConfirmPasswordInput.addEventListener('input', () => {
    MdpOk
    passwordMatching
});

let registrationFormInputs=document.querySelectorAll('.form-control');
registrationFormInputs.forEach(input => {
    input.addEventListener('input', CheckForm);
});



emailInput.addEventListener('input', validateEmail);
function validateEmail() {
    let email = emailInput.value;
    let emailSpan = document.querySelector('#emailSpan');
    // Réinitialiser les messages et les classes
    emailSpan.innerText = '';
    emailSpan.classList.remove('text-danger', 'text-success');
    // Vérifie si l'email est défini et non vide
    if (!email || email === "undefined") {
        emailSpan.innerText = 'Veuillez entrer une adresse email valide';
        emailSpan.classList.add('text-danger');
        return false;
    }
    // Vérifie la longueur de l'email
    if (email.length < 5 || email.length > 320) {
        emailSpan.innerText = 'L\'adresse email doit contenir entre 5 et 320 caractères';
        emailSpan.classList.add('text-danger');
        return false;
    }
    // Vérifie la présence de '@'
    let atSymbol = email.indexOf('@');
    if (atSymbol === -1) {
        emailSpan.innerText = 'L\'adresse email doit contenir un "@"';
        emailSpan.classList.add('text-danger');
        return false;
    }
    // Vérifie la présence de '.'
    let dotSymbol = email.lastIndexOf('.');
    if (dotSymbol === -1) {
        emailSpan.innerText = 'L\'adresse email doit contenir un "."';
        emailSpan.classList.add('text-danger');
        return false;
    }
    // Vérifie qu'il n'y a pas d'espace
    let spaceSymbol = email.indexOf(' ');
    if (spaceSymbol !== -1) {
        emailSpan.innerText = 'L\'adresse email ne doit pas contenir d\'espaces';
        emailSpan.classList.add('text-danger');
        return false;
    }
    // Vérifie que '.' vient après '@'
    if (dotSymbol < atSymbol) {
        emailSpan.innerText = 'L\'adresse email doit contenir un "@" avant le "."';
        emailSpan.classList.add('text-danger');
        return false;
    }
    if(email.lastIndexOf('.') === email.length - 1){
        emailSpan.innerText = 'L\'adresse email ne doit pas se terminer par un "."';
        emailSpan.classList.add('text-danger');
        return false;
    }
    // Si toutes les validations passent
    emailSpan.innerText = 'L\'adresse email est valide';
    emailSpan.classList.add('text-success');
    return true;
}






function displayValidationMessage(){
    let errorSpan = document.querySelector('#validationSpan');
    errorSpan.innerText = 'Password must be 8-20 characters long, contain at least one lowercase letter, one uppercase letter, one number, and two special characters';
}



function passwordMatching(){
    let password = PasswordInput.value; 
    let ConfirmPassword = ConfirmPasswordInput.value;
    let MatchingSpan = document.querySelector('#passwordMatchSpan');
    if(password !== ConfirmPassword){
        MatchingSpan.innerText = 'Les mots de passe ne correspondent pas';
        MatchingSpan.classList.add('text-danger');
        return false;
    }
    if(password.length === 0 || ConfirmPassword.length === 0){
        MatchingSpan.innerText = '';
        return false;
    }
    MatchingSpan.innerText = 'Les mots de passe correspondent';
    MatchingSpan.classList.remove('text-danger');
    MatchingSpan.classList.add('text-success');
    return true;
}


function passwordValidation() {
    let password = PasswordInput.value;
    let validationSpan = document.querySelector('#validationSpan');
    let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=(?:.*[^\da-zA-Z]){2,}).{8,20}$/;
    validationSpan.innerText = '';
    validationSpan.classList.remove('text-danger', 'text-success');
    if (!password){
        validationSpan.innerText = 'Veuillez entrer un mot de passe';
        validationSpan.classList.add('text-danger');
        return false;
    }
    if(!passwordRegex.test(password)){
        validationSpan.innerText = 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et deux caractères spéciaux';
        validationSpan.classList.add('text-danger');
        return false;
    }
    validationSpan.innerText = 'Le mot de passe correspond aux critères de sécurité';
    validationSpan.classList.remove('text-danger');
    validationSpan.classList.add('text-success');
    return true;
}



function verificationMotDePasse(){
    let isValid = passwordValidation();
    let validationSpan= document.querySelector('#validationSpan');  
    if(isValid){
    validationSpan.innerText = 'Le mot de passe correspond aux critères de sécurité';
    validationSpan.classList.remove('text-danger');
    validationSpan.classList.add('text-success');
    } else {
        validationSpan.classList.remove('text-success');    
        validationSpan.classList.add('text-danger');
        validationSpan.innerText = 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et deux caractères spéciaux';
    }
}


function MdpOk(){
    let isValid = passwordValidation();
    let passwordMatch = passwordMatching();
    if(isValid && passwordMatch){
        ValidPasswordInput(); // Ajoute la class is-valid
        return true;
        
    }
    InvalidPasswordInput(); // Ajoute la class is-invalid
    return false;
}

function ValidPasswordInput(){
    PasswordInput.classList.remove('is-invalid');
    ConfirmPasswordInput.classList.remove('is-invalid');
    PasswordInput.classList.add('is-valid');
    ConfirmPasswordInput.classList.add('is-valid');
}

function InvalidPasswordInput(){
    PasswordInput.classList.remove('is-valid');
    ConfirmPasswordInput.classList.remove('is-valid');
    PasswordInput.classList.add('is-invalid');
    ConfirmPasswordInput.classList.add('is-invalid');

}
roleInput.addEventListener('input', validateRole);

function validateRole(){
    let role = roleInput.value;
    let roleSpan = document.querySelector('#roleSpan');
    if(!role || role==="undefined"){
        roleSpan.innerText = 'Veuillez choisir un rôle';
        roleSpan.classList.add('text-danger');
        return false;
    }
    roleSpan.innerText = 'Le rôle est valide';
    roleSpan.classList.remove('text-danger');
    roleSpan.classList.add('text-success');
    return true;
}
registrationForm.addEventListener('input', CheckForm);

function CheckForm(){

    let EmailValide = validateEmail();
    let RoleValide = validateRole();
    let MdpValide = MdpOk();
    if(EmailValide && RoleValide && MdpValide){
        EnableSubmitButton();
        return true;
    }
    DisableSubmitButton();
    return false;
}

function EnableSubmitButton(){
    let submitButton = document.querySelector('#registerNewUserBtn');
    if(submitButton){

    }
    submitButton.disabled = false;
    

}

function DisableSubmitButton(){
    submitButton.disabled = true;
}