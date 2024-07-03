const registrationForm = document.querySelector('#registrationForm');

const emailInput = document.querySelector('#email');
const email = emailInput.value;

const PasswordInput = document.querySelector('#password');
const password = PasswordInput.value;

const ConfirmPasswordInput = document.querySelector('#confirmPassword');
const confirmPassword = ConfirmPasswordInput.value;

function displayErrorMessage(){
    const errorSpan = document.querySelector('#errorSpan');
    
}

function passwordMatching(){
    if(password !== confirmPassword){
        alert('Password does not match');
        return false;
    }
    return true;
}

function passwordValidation(){
    if(password.length<8){
        displa
    }
}
