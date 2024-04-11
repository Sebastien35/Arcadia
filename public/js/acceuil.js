let starRating = document.querySelector('.starRating');
let stars = document.querySelectorAll('.star');

starRating.addEventListener('input', function() {
    let rating = parseInt(this.value);
    console.log(rating);
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

const pseudoInput = document.getElementById('avis_pseudo');
const avisContentInput = document.getElementById('avisContentInput');

const avisInput = document.querySelector('.avisInput');
const avisLen = document.getElementById('avisLen');
const btnSendReview = document.querySelector('.btnSendReview');
avisInput.addEventListener('input', function() {
    let avisContent = this.value;
    avisLen.innerHTML = `${avisContent.length}/255`;
    validationLenAvis_Content();
});




/* Validation formulaire */
function validationLenAvis_Content(){
    let avisContent = avisInput.value;
    if(avisContent.length < 10 || avisContent.length > 255){
        avisInput.classList.add('is-invalid');
        avisLen.innerHTML= `Dites nous en plus...`;
        avisLen.classList.add('text-danger');
        return false;
    } else {
        avisInput.classList.remove('is-invalid');
        avisInput.classList.add('is-valid');
        return true;
    }
}

const noteInput = document.getElementById('avis_note')
noteInput.addEventListener('input', function() {
    validationNote();
});
document.addEventListener('DOMContentLoaded', function() {
    validationNote();

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
    validationLenPseudo();
});

function validationLenPseudo(){
    let pseudo = pseudoInput.value;
    if(pseudo.length < 3 || pseudo.length > 20){
        pseudoInput.classList.add('is-invalid');
        return false;
    } else {
        pseudoInput.classList.remove('is-invalid');
        pseudoInput.classList.add('is-valid');
        return true;
    }
}

avisInput.addEventListener('input', validateForm);
pseudoInput.addEventListener('input', validateForm);

function validateForm(){
    if (validationLenPseudo() && validationLenAvis_Content() && validationNote()){
        btnSendReview.classList.remove('disabled');
    }else{
        btnSendReview.classList.add('disabled');
    }
}

