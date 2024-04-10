const pseudoInput = document.getElementById('pseudoInput');
const noteInput = document.getElementById('noteInput');
const avisContentInput = document.getElementById('avisContentInput');





/* Afficher la liste des avis 13/03/2024 */
const avisListContainer = document.getElementById('avis-list-container');
const seeAvisBtn=document.querySelector('.see-avis-btn');
seeAvisBtn.addEventListener('click', function(){
    flushFeatures();
    flushActive();
    avisListContainer.classList.remove('d-none');
    seeAvisBtn.classList.add('active');
});


/* Afficher le formulaire d'ajout d'avis 13/03/2024 */
const createAvisContainer = document.getElementById('create-avis-container');
const createAvisBtn=document.querySelector('.create-avis-btn');
createAvisBtn.addEventListener('click', function(){
    flushFeatures();
    flushActive();
    createAvisContainer.classList.remove('d-none');
    createAvisBtn.classList.add('active');
});

// Supprimer un avis:

document.addEventListener('DOMContentLoaded', function() {
    let deleteAvisBtns = document.querySelectorAll('.delete-avis');
    deleteAvisBtns.forEach(button => {
        button.addEventListener('click', function() {
            let avisId = this.getAttribute('data-id');
            let avisIdContainer = document.getElementById('avisIdContainer');
            avisIdContainer.value = avisId;
        });
    });

    let confirmDeleteAvisBtn = document.getElementById('btn-confirm-delete');
    confirmDeleteAvisBtn.addEventListener('click', deleteAvis);
});

async function deleteAvis() {
    let avisId = document.getElementById('avisIdContainer').value;
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");
    try {
        const response = await fetch(`/avis/delete/${avisId}`, {
            method: 'DELETE',
            headers: myHeaders,
        });
        if (response.ok) {
            window.location.reload();
        }
    } catch (error) {
        alert('Une erreur est survenue lors de la suppression de l\'avis');
    }
}




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


/*************************************************************************/

/* AFFICHAGE CONTENU /*
/* Flush Features 13/03/2024 */
function flushFeatures(){
    createAvisContainer.classList.add('d-none');
    avisListContainer.classList.add('d-none');
}
flushFeatures();

/* Flush Active 13/03/2024 */
function flushActive(){
    createAvisBtn.classList.remove('active');
    seeAvisBtn.classList.remove('active');
}
flushActive();

function defaultBehaviour(){
    seeAvisBtn.classList.add('active');
    avisListContainer.classList.remove('d-none');
}
defaultBehaviour();

