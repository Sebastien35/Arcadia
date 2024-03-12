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
async function deleteHabitat() {
    try {
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');
        let targetId = document.getElementById('habitat-id').value;      
        const response = await fetch(`/admin/habitats/delete/${targetId}`, {
            method: 'DELETE',
            headers: myHeaders,
        });
        if (response.ok) {
            window.location.reload();
            const result = await response.json();
        } else {
            throw new Error('Erreur');
        }
    } catch (error) {
        console.log(error);
    }
}

//Afficher commentaires

document.addEventListener('DOMContentLoaded', function() {
    // Récupérer tous les boutons "Commentaires"
    let commentButtons = document.querySelectorAll('.commentsBt');
    // Ajouter un gestionnaire d'événements à chaque bouton "Commentaires"
    commentButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Récupérer la section des commentaires correspondante
            let commentsDiv = button.nextElementSibling;
            // Vérifier si la section des commentaires est actuellement visible ou non
            let isVisible = commentsDiv.classList.contains('d-none');
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
// Le passage d'id animal est assuré par le bouton de suppression, logique dans allAnimals.js
const confirmDeleteAnimalBtn = document.getElementById('confirm-delete-animal-btn');
confirmDeleteAnimalBtn.addEventListener('click', deleteAnimal);

function deleteAnimal() {
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let targetId = document.getElementById('delete-animal-id').value;
    console.log('Target ID:', targetId); // Debug log
    fetch(`/admin/animal/delete/${targetId}`, {
        method: 'DELETE',
        headers: myHeaders,
    })
    .then(response => {
        if (response.ok) {
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

const btndelteinfoAnimals = document.querySelectorAll('[data-infoAnimal-id]');
btndelteinfoAnimals.forEach(button=>{
    button.addEventListener('click', function(){
        const infoAnimalId = button.getAttribute('data-infoAnimal-id');
        const infoAnimalIdContainer = document.getElementById('infoAnimal-id');
        infoAnimalIdContainer.value = infoAnimalId;
    });
});

const confirmDeleteinfoAnimalBtn = document.getElementById('confirm-delete-infoAnimal-btn');
confirmDeleteinfoAnimalBtn.addEventListener('click', deleteInfoAnimal);

async function deleteInfoAnimal() {
    try {
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');
        let targetId = document.getElementById('infoAnimal-id').value;        
        const response = await fetch(`/admin/infoAnimals/delete/${targetId}`, {
            method: 'DELETE',
            headers: myHeaders,
        });
        if (response.ok) {
            const result = await response.json();
            window.location.reload();
            return result;
        } else {
            throw new Error('Erreur');
        }
    } catch (error) {
        console.log(error);
    }
}





/*----------------- Filtrer infoAnimals ----------------- */

function applyinfoAnimalFilters() {
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
animalSelect.addEventListener('change', applyinfoAnimalFilters);
dateSelect.addEventListener('change', applyinfoAnimalFilters);
applyinfoAnimalFilters();


/*--------------------------Services--------------------------*/
const servicesContainer  = document.getElementById('services-container');
const servicesBtn = document.getElementById('servicesBtn');

servicesBtn.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    servicesContainer.classList.remove('d-none');
    servicesBtn.classList.add('active');
});

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


/*-----------demandes de contact 05/03/2024 ------------------ */
const contactContainer = document.getElementById('contactContainer');
const contactBtn = document.getElementById('contactBtn');

contactBtn.addEventListener('click', showContact);
function showContact(){
    FlushFeatures();
    FlushActive();
    contactBtn.classList.add('active');
    contactContainer.classList.remove('d-none');
}

// Répondre à une demande de contact
const contactResponseBtns = document.querySelectorAll('[data-demande-id]');
contactResponseBtns.forEach(button => {
    button.addEventListener('click', function() {
        const demandeId = button.getAttribute('data-demande-id');
        const demandeIdContainer = document.getElementById('demandeId');
        demandeIdContainer.value = demandeId; // Utilize .value for form elements
    });
});

const sendResponseBtn = document.getElementById('btnConfirmRepondre');
sendResponseBtn.addEventListener('click', sendResponse);

async function sendResponse() {
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let dataForm = new FormData(repondreForm);
    let targetId = document.getElementById('demandeId').value;
    console.log('targetId', targetId)
    let raw = JSON.stringify({
        "response": dataForm.get('reponse')
    });
    console.log('raw', raw);
    let requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    };
    try {
        let response = await fetch(`/employe/demande/repondre/${targetId}`, requestOptions);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        // Handle success
        console.log('Response sent successfully');
        window.location.reload();
    } catch (error) {
        // Handle error
        console.error('Error:', error);
    }
}

async function deleteDemande($id){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let requestOptions = {
        method: 'DELETE',
        headers: myHeaders,
        redirect: 'follow'
    };
    try {
        let response = await fetch(`/admin/demande/delete/${$id}`, requestOptions);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        let result = await response.json();
        console.log(result);
        window.location.reload();
    } catch (error) {
        window.location.reload();
        console.error('Error:', error);
        
    }

}


// Filtrer les demandes de contact
function applyDemandeContactFilter(){
    const targetedStatus = document.getElementById('demandeStatusSelect').value;
    const targetedDate = document.getElementById('demande-date-select').value;
    const demandeEntry = document.querySelectorAll('.demande-card');    
    demandeEntry.forEach(item => {
        const status = item.getAttribute('data-demande-status') === 'true' || item.getAttribute('data-demande-status') === ''; // Modifier cette ligne
        let statusMatch;
        if (targetedStatus === '*') {
            statusMatch = true; // Si '*' est sélectionné, toutes les demandes sont considérées comme correspondantes
        } else {
            statusMatch = (targetedStatus === '1' && status) || (targetedStatus === '0' && !status); // Inverser la comparaison
        }
        const dateMatch = (targetedDate === '') || (item.getAttribute('data-demande-date') === targetedDate);
        if (statusMatch && dateMatch) {
            item.classList.remove('d-none');
        } else {
            item.classList.add('d-none');
        }
    });
}
const demandeStatusSelect = document.getElementById('demandeStatusSelect');
demandeStatusSelect.addEventListener('change', applyDemandeContactFilter);

const demandeDateSelect = document.getElementById('demande-date-select');
demandeDateSelect.addEventListener('change', applyDemandeContactFilter);

applyDemandeContactFilter();

/*----------------- Consultations des animaux -----------------*/

const consultationContainer = document.getElementById('consultationContainer');
const consultationContainerbtn = document.getElementById('consultationContainerBtn')

consultationContainerbtn.addEventListener('click', showConsultation);
function showConsultation(){
    FlushFeatures();
    FlushActive();
    consultationContainerbtn.classList.add('active');
    consultationContainer.classList.remove('d-none');
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
    contactContainer.classList.add('d-none');
    consultationContainer.classList.add('d-none');
    
}



/* Remove .active class from the sidebar */

function FlushActive(){
    userBtn.classList.remove('active');
    habitatBtn.classList.remove('active');
    animalBtn.classList.remove('active');
    infoAnimalBtn.classList.remove('active');
    servicesBtn.classList.remove('active');
    horairesBtn.classList.remove('active');
    contactBtn.classList.remove('active');
    consultationContainerbtn.classList.remove('active');

}