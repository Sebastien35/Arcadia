// Script for the admin dashboard

/*---------------- Display User Container ------------------*/
const userContainer = document.getElementById('user-container');
const userBtn = document.getElementById('userBtn');

userBtn.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    
    userContainer.classList.remove('d-none');
    userBtn.classList.add('active');
    
});

// Delete User:
document.addEventListener('DOMContentLoaded', function(){
    const deleteUserBtns = document.querySelectorAll('[data-user-id]');
    deleteUserBtns.forEach(button=>{
        button.addEventListener('click', function(){
            const userId = button.getAttribute('data-user-id');
            const userIdContainer = document.getElementById('user-id');
            userIdContainer.value = userId;
        });
    });
});

const confirmDeleteUserBtn = document.getElementById('confirm-delete-user-btn');
confirmDeleteUserBtn.addEventListener('click', deleteUser);

function deleteUser(){
    let targetId = document.getElementById('user-id').value; // Use 'user-id' instead of 'userId'
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    fetch(`/admin/user/delete/${targetId}`, { // Use template literal for URL
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

// Edit User:
document.addEventListener('DOMContentLoaded', function(){
    const editUserBtns = document.querySelectorAll('[data-user-id]');
    editUserBtns.forEach(button=>{
        button.addEventListener('click', function(){
            const userId = button.getAttribute('data-user-id');
            const userIdContainer = document.getElementById('edit-user-id');
            userIdContainer.value = userId;
        });
    });
});

const confirmEditUserBtn = document.getElementById('confirm-edit-user-btn');
confirmEditUserBtn.addEventListener('click', editUser);

function editUser(){
    let targetId = document.getElementById('edit-user-id').value;
    let email = document.getElementById('edit-email').value;
    let role = [document.getElementById('edit-role').value]; // Convert role to array
    let plainPassword = document.getElementById('edit-plainPassword').value;

    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');

    let userData = {
        email: email,
        roles: role, 
        plainPassword: plainPassword
    };

    fetch(`/admin/user/edit/${targetId}`, {
        method: 'PUT',
        headers: myHeaders,
        body: JSON.stringify(userData), 
        redirect: 'follow'
    })
    .then(response => {
        if(response.ok){
            window.location.reload();
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => console.log(error));
}


/* ----------------- Habitat Container ----------------- */
const habitatContainer = document.getElementById('habitat-container');
const habitatBtn = document.getElementById('habitatBtn');

const commentairesBtn = document.getElementById('commentairesBtn');

habitatBtn.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    habitatContainer.classList.remove('d-none');
    habitatBtn.classList.add('active');
});

const deleteHabitatBtns = document.querySelectorAll('[data-habitat-id]');
deleteHabitatBtns.forEach(button=>{
    button.addEventListener('click', function(){
        const habitatId = button.getAttribute('data-habitat-id');
        const habitatIdContainer = document.getElementById('habitat-id');
        habitatIdContainer.value = habitatId;
    });
});

const confirmDeleteHabitatBtn = document.getElementById('confirm-delete-habitat-btn');
confirmDeleteHabitatBtn.addEventListener('click', deleteHabitat);
function deleteHabitat(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let targetId = document.getElementById('habitat-id').value;
    fetch(`/admin/habitats/delete/${targetId}`, {
        method: 'DELETE',
        headers: myHeaders,
        
    })
    .then(response => {
        if(response.ok){
            window.location.reload();
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => console.log(error));
}

//Afficher commentaires

document.addEventListener('DOMContentLoaded', function() {
    // Récupérer tous les boutons "Commentaires"
    var commentButtons = document.querySelectorAll('.commentsBt');
    // Ajouter un gestionnaire d'événements à chaque bouton "Commentaires"
    commentButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Récupérer la section des commentaires correspondante
            var commentsDiv = button.nextElementSibling;
            // Vérifier si la section des commentaires est actuellement visible ou non
            var isVisible = commentsDiv.classList.contains('d-none');
            // Afficher ou masquer la section des commentaires en fonction de son état actuel
            if (isVisible) {
                // Si la section des commentaires est masquée, la rendre visible
                commentsDiv.classList.remove('d-none');
            } else {
                // Sinon, la masquer
                commentsDiv.classList.add('d-none');
            }
        });
    });
});





/* -----------------Animal Container ----------------- */
const animalContainer = document.getElementById('animal-container');
const animalBtn = document.getElementById('animalBtn');

animalBtn.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    animalContainer.classList.remove('d-none');
    animalBtn.classList.add('active');
});

//Supprimer Animal --------------------------------------------------------

const deleteAnimalBtns = document.querySelectorAll('[data-animal-id]');
deleteAnimalBtns.forEach(button=>{
    button.addEventListener('click', function(){
        const animalId = button.getAttribute('data-animal-id');
        const animalIdContainer = document.getElementById('animal-id');
        animalIdContainer.value = animalId;
    });
});

const confirmDeleteAnimalBtn = document.getElementById('confirm-delete-animal-btn');
confirmDeleteAnimalBtn.addEventListener('click', deleteAnimal);
function deleteAnimal(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let targetId = document.getElementById('animal-id').value;
    fetch(`/admin/animal/delete/${targetId}`, {
        method: 'DELETE',
        headers: myHeaders,
        
    })
    .then(response => {
        if(response.ok){
            window.location.reload();
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => console.log(error));

}




/*-----------------infoAnimal Container ----------------- */
const infoAnimalContainer = document.getElementById('info-animal-container');
const infoAnimalBtn = document.getElementById('infoAnimalBtn');

infoAnimalBtn.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    infoAnimalContainer.classList.remove('d-none');
    infoAnimalBtn.classList.add('active');
});

/*----------------- Filtrer infoAnimals ----------------- */

function applyFilters() {
    const animalId = animalSelect.value;
    const date = dateSelect.value;
    const infoAnimalRow = document.querySelectorAll('.infoAnimalRow');

    infoAnimalRow.forEach(row => {
        const animalMatch = (animalId == 0) || (row.getAttribute('data-animal-id') == animalId);
        const dateMatch = (date == '') || (row.getAttribute('data-infoAnimal-date') == date);

        if (animalMatch && dateMatch) {
            row.classList.remove('d-none');
        } else {
            row.classList.add('d-none');
        }
    });
}
const animalSelect = document.getElementById('animal-select');
const dateSelect = document.getElementById('date-select');
animalSelect.addEventListener('change', applyFilters);
dateSelect.addEventListener('change', applyFilters);
applyFilters();


/*--------------------------Services--------------------------*/
const servicesContainer  = document.getElementById('services-container');
const servicesBtn = document.getElementById('servicesBtn');

servicesBtn.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    servicesContainer.classList.remove('d-none');
    servicesBtn.classList.add('active');
});

//Créer un service:
const createServiceBtn = document.getElementById('create-service-btn');
createServiceBtn.addEventListener('click', createService);
function createService(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let form = new FormData(document.getElementById('create-service-form'));
    let raw= JSON.stringify(
        {
            "nom" : sanitizeHTML(form.get('nom')), 
            "description" : sanitizeHTML(form.get('description')),
        }
    );
    
    fetch('/admin/services/create', {
        method: 'POST',
        headers: myHeaders,
        body: raw
    })
    .then(response => {
        if(response.ok){
            window.location.reload();
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => alert('Une erreur est survenue', error));
}

// Supprimer un service:

const deleteServiceBtns = document.querySelectorAll('[data-service-id]');
deleteServiceBtns.forEach(button=>{
    button.addEventListener('click', function(){
        const serviceId = button.getAttribute('data-service-id');
        const serviceIdContainer = document.getElementById('service-id');
        serviceIdContainer.value = serviceId;
    });
});
const confirmDeleteServiceBtn = document.getElementById('confirm-delete-service-btn');
confirmDeleteServiceBtn.addEventListener('click', deleteService);
function deleteService(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let targetId = document.getElementById('service-id').value;
    fetch(`/admin/services/delete/${targetId}`, {
        method: 'DELETE',
        headers: myHeaders,
        
    })
    .then(response => {
        if(response.ok){
            window.location.reload();
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => alert('Une erreur est survenue', error));
}

// Modifier un service:
const editserviceBtns = document.querySelectorAll('[data-service-id]');
editserviceBtns.forEach(button=>{
    button.addEventListener('click', function(){
        const serviceId = button.getAttribute('data-service-id');
        const serviceIdContainer = document.getElementById('edit-service-id');
        serviceIdContainer.value = serviceId;
    });
});
const confirmEditServiceBtn = document.getElementById('confirm-edit-service-btn');
confirmEditServiceBtn.addEventListener('click', editService);
function editService(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let targetId = document.getElementById('edit-service-id').value;
    let form = new FormData(document.getElementById('edit-service-form'));
    let raw= JSON.stringify(
        {
            "nom" : sanitizeHTML(form.get('edit-nom')), 
            "description" : sanitizeHTML(form.get('edit-description')),
        }
    );
    fetch(`/admin/services/edit/${targetId}`, {
        method: 'PUT',
        headers: myHeaders,
        body: raw
    })
    .then(response => {
        if(response.ok){
            window.location.reload();
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => alert('Une erreur est survenue', error));

}

/*----------------- Horaires ----------------- */
const horairesContainer = document.getElementById('horaires-container');   
const horairesBtn = document.getElementById('horairesBtn'); 

horairesBtn.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    horairesContainer.classList.remove('d-none');
    horairesBtn.classList.add('active');
});

//Modifier les horaires:
const editHoraireBtns = document.querySelectorAll('[data-horaire-id]');
editHoraireBtns.forEach(button=>{
    button.addEventListener('click', function(){
        const horaireId = button.getAttribute('data-horaire-id');
        const horaireIdContainer = document.getElementById('edit-horaire-id');
        horaireIdContainer.value = horaireId;
    });
});

const confirmEditHoraireBtn = document.getElementById('confirm-edit-horaire-btn');
confirmEditHoraireBtn.addEventListener('click', editHoraire);

function editHoraire(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let targetId = document.getElementById('edit-horaire-id').value;
    //console.log(targetId); DEBUG
    let form = new FormData(document.getElementById('edit-horaire-form'));
    let isOuvert=$('#isOuvert').is(':checked')  ? true:false;
    let raw=JSON.stringify({
        "ouverture": document.getElementById('HOuverture').value,
        "fermeture": document.getElementById('HFermeture').value,
        "ouvert": isOuvert
    
    })
    // Construct the JSON object
    // console.log(raw);
    fetch(`/admin/horaires/edit/${targetId}`, {
        method: 'PUT',
        headers: myHeaders,
        body: raw
    })
    .then(response => {
        if(response.ok){
            window.location.reload();
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => console.log('Une erreur est survenue', error));

}








/*----------------- Display / Hide Features -----------------*/

//Default container
const defaultContainer = document.getElementById('default-container');


function FlushFeatures(){
    userContainer.classList.add('d-none');
    habitatContainer.classList.add('d-none');
    animalContainer.classList.add('d-none');
    infoAnimalContainer.classList.add('d-none');
    servicesContainer.classList.add('d-none');
    horairesContainer.classList.add('d-none');
    
}



/* Remove .active class from the sidebar */

function FlushActive(){
    userBtn.classList.remove('active');
    habitatBtn.classList.remove('active');
    animalBtn.classList.remove('active');
    infoAnimalBtn.classList.remove('active');
    servicesBtn.classList.remove('active');
    horairesBtn.classList.remove('active');

}