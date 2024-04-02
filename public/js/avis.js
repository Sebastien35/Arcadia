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

document.addEventListener('DOMContentLoaded', function(){
    const deleteAvisBtns = document.querySelectorAll('[data-id]');
    deleteAvisBtns.forEach(button=>{
        button.addEventListener('click', function(){
            const avisId = button.getAttribute('data-id');
            const userIdContainer = document.getElementById('userId');
            userIdContainer.value = avisId;
            console.log(avisId);
        })
    })
    
})

async function deleteAvis(){
    console.log('deleteAvis');
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let avisId= document.getElementById('userIdContainer').value;
    let requestOptions = {
        method: 'DELETE',
        headers: myHeaders,
        redirect: 'follow'
    };
    await fetch(`/avis/delete/${avisId}`, requestOptions)
    .then(response => {
        if(response.ok){
            window.location.reload();
        }else{
            console.log('Erreur lors de la suppression de l\'avis')
        }
    })
}
btnConfirmDelete = document.getElementById('btn-confirm-delete');
btnConfirmDelete.addEventListener('click', deleteAvis);




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

