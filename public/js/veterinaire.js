
/*----------------------- Animaux -------------------------------------*/
const animalContainer = document.getElementById('animal-container');
const animalBtn = document.getElementById('animal-btn');

animalBtn.addEventListener('click', showAnimalContainer);

function showAnimalContainer(){
    flushFeatures();
    flushActive();
    animalContainer.classList.remove('d-none');
    animalBtn.classList.add('active');
}


// Ajouter infoAnimal 
//Transmettre id de l'animal à la modal

document.addEventListener('DOMContentLoaded', function(){
    const addInfoAnimalBtns = document.querySelectorAll('[data-animal-id]');
    addInfoAnimalBtns.forEach(button=>{
        button.addEventListener('click', function(){
            const animalId = button.getAttribute('data-animal-id');
            const animalIdContainer = document.getElementById('animalId');
            animalIdContainer.value = animalId;
        });
    });
});
//Fonction POST infoAnimal

const addInfoAnimalBtn = document.getElementById('confirm-add-info-animal-btn');
const addInfoAnimalForm = document.getElementById('add-info-animal-form');



addInfoAnimalBtn.addEventListener('click', addInfoAnimal);

function addInfoAnimal() {
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');

    let dataForm = new FormData(addInfoAnimalForm);

    // Get the selected nourriture value directly
    

    let raw = JSON.stringify({
        'animal': dataForm.get('animal'),
        'etat': dataForm.get('animal-etat'),
        'details': dataForm.get('animal-etat-details'),
        'nourriture': dataForm.get('animal-nourriture'),
        'grammage': dataForm.get('animal-grammage'),
    });

    let requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    };

    fetch('/veterinaire/animal/info/create', requestOptions)
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                console.log('Erreur : ' + requestOptions.body);
                throw new Error('Erreur');
            }
        })
        .then(result => {
            window.location.reload();
        })
        .catch(error => console.log('error', error));
}

//Supprimer Animal --------------------------------------------------------

const confirmDeleteAnimalBtn = document.getElementById('confirmDeleteAnimalBtn');

confirmDeleteAnimalBtn.addEventListener('click', deleteAnimal);

function deleteAnimal(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    
    let animalId = document.getElementById('animalId').value;
    
    fetch('/veterinaire/animal/delete/'+animalId, {
        method: 'DELETE',
        headers: myHeaders,
        redirect: 'follow'
    })
    .then(response => {
        if(response.ok){
            window.location.reload();
            return response.json();
        }else{
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => console.log(error));
}

/*----------------------- Nourriture -------------------------------------*/
const nourritureContainer = document.getElementById('nourriture-container');
const nourritureBtn = document.getElementById('nourriture-btn');

nourritureBtn.addEventListener('click', showNourritureContainer);

function showNourritureContainer(){
    flushFeatures();
    flushActive();
    nourritureContainer.classList.remove('d-none');
    nourritureBtn.classList.add('active');
}

//Ajouter Nourriture-------------------------------------------------------

const addNourritureBtn = document.getElementById('add-nourriture-btn');
const nourritureForm = document.getElementById('add-nourriture-form');

addNourritureBtn.addEventListener('click', addNourriture);

function addNourriture(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');

    let dataForm = new FormData(nourritureForm);
    let raw = JSON.stringify(
        {
            "nourriture-nom":dataForm.get('nourriture-nom'),
            "nourriture-description":dataForm.get('nourriture-description'),
        }
    );

    fetch('/veterinaire/nourriture/new', {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    })
    .then(response => {
        if(response.status === 200 | 201 ){
            return response.json();
        }else{
            throw new Error('Erreur');
        }
    })
    .then(result => {

        window.location.reload();
    })
    .catch(error => console.log(error));

}

// Supprimer nourriture-------------------------------------------------------

const deleteNourritureBtns = document.querySelectorAll('.delete-nourriture-btn');
deleteNourritureBtns.forEach(button=>{
    button.addEventListener('click', function(){
        let nourritureId = button.getAttribute('data-nourriture-id');
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');


        fetch('/veterinaire/nourriture/delete/'+nourritureId, {
            method: 'DELETE',
            headers: myHeaders,
            redirect: 'follow'
        })
        .then(response => {
            if(response.ok){
                window.location.reload();
                return response.json();
            }else{
                throw new Error('Erreur');
            }
        })
        .then(result => {
            window.location.reload();
        })
        .catch(error => console.log(error));
    });
});

// Modifier Nourriture-------------------------------------------------------

document.addEventListener('DOMContentLoaded', function(){
    const editNourritureBtns = document.querySelectorAll('[data-nourriture-id]');
    editNourritureBtns.forEach(button=>{
        button.addEventListener('click', function(){
            const nourritureId = button.getAttribute('data-nourriture-id');
            const nourritureIdContainer = document.getElementById('nourritureIdContainer');
            nourritureIdContainer.value = nourritureId;
        });
    });
});

const confirmEditNourritureBtn = document.getElementById('confirmEditNourritureBtn');

confirmEditNourritureBtn.addEventListener('click', editNourriture);

function editNourriture(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');

    let dataForm = new FormData(document.getElementById('edit-nourriture-form'));
    let raw = JSON.stringify(
        {
            "nourriture-nom":dataForm.get('nourriture-nom'),
            "nourriture-description":dataForm.get('nourriture-description'),
        }
    );

    fetch('/veterinaire/nourriture/edit/'+dataForm.get('nourriture-id'), {
        method: 'PUT',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    })
    .then(response => {
        if(response.status === 200 | 201 ){
            return response.json();
        }else{
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => console.log(error));
}



/*-----------Affichage des repas des animaux 23/02/2024------------ */

const repasContainer = document.getElementById('repas-container');
const repasBtn = document.getElementById('repasBtn');

repasBtn.addEventListener('click', showRepas);

function showRepas(){
    flushFeatures();
    flushActive();
    repasBtn.classList.add('active');
    repasContainer.classList.remove('d-none');

}
/*-----------------------Habitats------------------------------*/

const habitatContainer = document.getElementById('habitat-container');
const habitatBtn = document.getElementById('habitatsBtn');

habitatBtn.addEventListener('click', showHabitatContainer);

function showHabitatContainer(){
    flushActive();
    flushFeatures();
    habitatBtn.classList.add('active');
    habitatContainer.classList.remove('d-none');

}
// Publier un commentaire sur un habitat

const addCommentBtns = document.querySelectorAll('.add-comment-btn');
addCommentBtns.forEach(buttons=>
    buttons.addEventListener('click', function(){
        const habitatId = buttons.getAttribute('data-habitat-id');
        const habitatIdContainer = document.getElementById('habitatIdContainer');
        habitatIdContainer.value = habitatId;
    })
);

const confirmAddCommentBtn = document.getElementById('confirm-add-comment-btn');
confirmAddCommentBtn.addEventListener('click', addComment);

function addComment(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let form = new FormData(document.getElementById('comment-habitat-form'));
        const commentaire = sanitizeHTML(form.get('habitat-comment'));
        let raw = JSON.stringify({
            'habitat': form.get('habitat-id'), // Make sure you have a field named 'habitat-id' in your form
            'commentaire': commentaire,
        });  
        fetch('/veterinaire/habitat/commentaire/new', {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        })
        .then(response => {
            if(response.ok){
                console.log(raw);
                return response.json();
            } else {
                throw new Error('Erreur');
            }
        })
        .then(result => {
            window.location.reload(); 
        })
        .catch(error => 
            console.log(error));
    }
    




/*-------------------------------------------------------------*/


// Afficher masquer features 
function flushFeatures(){
    animalContainer.classList.add('d-none')
    nourritureContainer.classList.add('d-none')
    repasContainer.classList.add('d-none')
    habitatContainer.classList.add('d-none')
}
flushFeatures();
function flushActive(){
    animalBtn.classList.remove('active');
    nourritureBtn.classList.remove('active');
    repasBtn.classList.remove('active');
    habitatBtn.classList.remove('active');
}
flushActive();