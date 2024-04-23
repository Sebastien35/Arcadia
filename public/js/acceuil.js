
let starRating = document.querySelector('.starRating');
let stars = document.querySelectorAll('.star');

starRating.addEventListener('input', function() {
    let rating = parseInt(this.value);
    updateStarColors(rating);
});

function updateStarColors(rating) {
    stars.forEach(star => {
        let starValue = parseInt(star.dataset.value);
        if (starValue <= rating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}

const avisInput = document.querySelector('.avisInput');
const avisLen = document.getElementById('avisLen');
const btnSendReview = document.querySelector('.btnSendReview');
avisInput.addEventListener('input', function() {
    let avisContent = this.value;
    avisLen.innerHTML = `${avisContent.length}/255`;
    validateComment();
});




/* Validation formulaire */
function validateComment(){
    let comment = avisInput.value;
    let regex = /^(?!.*[<>])[a-zA-Z0-9.'\s-]{10,255}$/;
    let errormsg = document.querySelector('.commentaire-error-msg');
    if(regex.test(comment)){
        avisInput.classList.remove('is-invalid');
        avisInput.classList.add('is-valid');
        errormsg.innerHTML = '';
        return true;
    }else{  
        avisInput.classList.add('is-invalid');
        avisInput.classList.remove('is-valid');
        errormsg.innerHTML = `Commentaire invalide. Le commentaire doit contenir entre 10 et 255 caractères alphanumériques.`;
        return false;
    }
}
/* Validation note */

const noteInput = document.getElementById('avis_note')
noteInput.addEventListener('input', function() {
    validationNote();
});
document.addEventListener('DOMContentLoaded', function() {

    noteInput.value = 0;

});
function validationNote(){
    let note = noteInput.value;
    if(note == null || note == 0 || note == undefined || note == ''){
        console.log('note invalide');
        console.log(noteInput.value);
        return false;
    } else {
        return true;
    }
}

pseudoInput.addEventListener('input', function() {
    validationPseudo();
});

function validationPseudo() {
    let errormsg = document.querySelector('.pseudo-error-msg');
    let pseudo = pseudoInput.value.trim(); 
    let regex = /^(?!.*[<>])[a-zA-Z0-9.\s-]{3,20}$/; // 
    if (regex.test(pseudo)) {
        pseudoInput.classList.remove('is-invalid');
        pseudoInput.classList.add('is-valid');
        errormsg.innerHTML = '';
        return true;
    } else {
        pseudoInput.classList.add('is-invalid');
        pseudoInput.classList.remove('is-valid');
        errormsg.innerHTML = `Pseudo invalide. Le pseudo doit contenir entre 3 et 20 caractères alphanumériques.`;  
        return false; 
    }
}



avisInput.addEventListener('input', validateForm);
pseudoInput.addEventListener('input', validateForm);
noteInput.addEventListener('input', validateForm);

function validateForm(){
    if (validationPseudo() && validateComment() && validationNote()){
        btnSendReview.classList.remove('disabled');
    }else{
        btnSendReview.classList.add('disabled');
    }
}
