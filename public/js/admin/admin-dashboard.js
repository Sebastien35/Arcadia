/*---------------- Display User Container ------------------*/
const userContainer = document.getElementById('user-container');
const userBtns = document.querySelectorAll('.userBtn');
userBtns.forEach(button => button.addEventListener('click', function() {
    FlushFeatures();
    FlushActive();
    getNonAdminUsers() 
    userContainer.classList.remove('d-none');
    button.classList.add('active'); // Use 'button' instead of 'userBtn' because 'button' is the current button being clicked
}));
//get all users
async function getNonAdminUsers() {
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    await fetch('/admin/user/nonAdmins')
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Erreur');
            }
        })
        .then(result => {
            let userTableBody = document.getElementById('userTableBody');
            userTableBody.innerHTML = '';
            let users = result;
            if (users.length === 0) {
                userTableBody.innerHTML = '<p class="text-center">Aucun utilisateur à afficher <i class="fa-solid fa-umbrella-beach"></i> </p>';
            }
            users.forEach(user => {
                let row = document.createElement('tr');
                row.classList.add('userRow');
                row.setAttribute('data-user-id', user.id);
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.email}</td>
                    <td>${user.roles}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu mb-2" >  
                                <ul>
                                <li class="btn btn-danger mb-1" id="delete-user" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="${user.id}"><i class="fa-solid fa-trash"></i></li>
                                <li class="btn btn-primary  mb-1"  data-bs-toggle="modal" data-bs-target="#editUserModal" data-user-id="${user.id}"><i class="fa-solid fa-pencil"></i></li>
                                </ul>  
                            </div> 
                        </div>
                    </td>
                `;
                userTableBody.appendChild(row);
            });

            const deleteUserBtns = document.querySelectorAll('[data-user-id]');
            deleteUserBtns.forEach(button => {
                button.addEventListener('click', function () {
                    const userId = button.getAttribute('data-user-id');
                    const userIdContainer = document.getElementById('user-id');
                    userIdContainer.value = userId;
                });
            });
        });
}

// Delete User:
const confirmDeleteUserBtn = document.getElementById('confirm-delete-user-btn');
confirmDeleteUserBtn.addEventListener('click', deleteUser);

function deleteUser() {
    let targetId = document.getElementById('user-id').value;
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    fetch(`/admin/user/delete/${targetId}`, {
            method: 'DELETE',
            headers: myHeaders,
            redirect: 'follow'
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
const habitatBtns = document.querySelectorAll('.habitatBtn');

habitatBtns.forEach(button => button.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    habitatContainer.classList.remove('d-none');
    button.classList.add('active');
}));

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
const animalBtns = document.querySelectorAll('.animalBtn');

animalBtns.forEach(button => button.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    animalContainer.classList.remove('d-none');
    button.classList.add('active');
}));

//Supprimer Animal --------------------------------------------------------
document.addEventListener('DOMContentLoaded', function(){
    const deleteAnimalBtns = document.querySelectorAll('[data-animal-id]');
    deleteAnimalBtns.forEach(button=>{
        button.addEventListener('click', function(){
            // console.log('Delete button clicked, target ID:', button.getAttribute('data-animal-id'));
            const animalId = button.getAttribute('data-animal-id');
            const animalIdContainer = document.getElementById('delete-animal-id');
            animalIdContainer.value = animalId;
        });
    });
});



const confirmDeleteAnimalBtn = document.getElementById('confirm-delete-animal-btn');
confirmDeleteAnimalBtn.addEventListener('click', deleteAnimal);

async function deleteAnimal() {
    try {
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');
        let targetId = document.getElementById('delete-animal-id').value;
        // console.log('Target ID:', targetId); // Debug log
        const response = await fetch(`/admin/animal/delete/${targetId}`, {
            method: 'DELETE',
            headers: myHeaders,
        });
        if (response.ok) {
            window.location.reload();
            return await response.json();
        } else {
            throw new Error('Erreur');
        }
    } catch (error) {
        console.log(error);
    }
}
//Rediriger vers /animal/show/:id
function goSeeAnimal(id){
    window.location.href = '/admin/animal/show/'+id;
}
//Rediriger vers /animal/edit/:id
function goEditAnimal(id){
    window.location.href = '/admin/animal/update/'+id;
}




/*-----------------infoAnimal Container ----------------- */
const infoAnimalContainer = document.getElementById('info-animal-container');
const infoAnimalBtns  = document.querySelectorAll('.infoAnimalBtn');

infoAnimalBtns .forEach(button => button.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    infoAnimalContainer.classList.remove('d-none');
    button.classList.add('active');
}));

async function getAllInfoAnimals(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    await fetch('/infoanimal/all')
    .then(response => {
        if(response.ok){
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        let infoAnimalTableBody = document.getElementById('infoAnimalTableBody');
        infoAnimalTableBody.innerHTML = '';
        let infoAnimals = result;
        if(infoAnimals.length === 0){
            infoAnimalTableBody.innerHTML = '<p class="text-center">Aucun compte-rendu pour le moment. <i class="fa-solid fa-umbrella-beach"></i> </p>';
        }
        let row = document.createElement('tr');
        row.classList.add('infoAnimalRow');
        
        infoAnimals.forEach(infoAnimal=>{
            if(infoAnimal.auteur === null){
                infoAnimal.auteur = {email: 'Utilisateur supprimé'};
            }
            row.setAttribute('data-animal-id', infoAnimal.animal.id);
            row.setAttribute('data-infoAnimal-date', toYMD(infoAnimal.createdAt));
            row.innerHTML = `
            <td>${infoAnimal.id}</td>
            <td>${toYMD(infoAnimal.createdAt)}</td>
            <td>${infoAnimal.animal.prenom}</td>
            <td>${infoAnimal.auteur.email}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu mb-2" aria-labelledby="dropdownMenuButton">    
                        <li class="btn btn-danger mb-1" id="delete-infoAnimal" data-bs-toggle="modal" data-bs-target="#deleteInfoAnimalModal" data-infoAnimal-id="${infoAnimal.id}"><i class="fa-solid fa-trash"></i></li>
                        <li class="btn btn-info  mb-1" onClick="goSeeInfoAnimal(${infoAnimal.id})"><i class="fa-regular fa-eye"></i></li>
                    </div> 
                </div>
            </td>
            `;
            infoAnimalTableBody.appendChild(row);
            row = document.createElement('tr');
            row.classList.add('infoAnimalRow');
        });
        const btndelteinfoAnimals = document.querySelectorAll('[data-infoAnimal-id]');
        btndelteinfoAnimals.forEach(button=>{
            button.addEventListener('click', function(){
            const infoAnimalId = button.getAttribute('data-infoAnimal-id');
            const infoAnimalIdContainer = document.getElementById('infoAnimal-id');
            infoAnimalIdContainer.value = infoAnimalId;
            });
        });
    });
}
function toYMD(dateString) {
    let date = new Date(dateString);
    let year = date.getFullYear();
    let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Month is 0-indexed, so add 1
    let day = date.getDate().toString().padStart(2, '0');
    let formattedDate = `${year}-${month}-${day}`;
    return formattedDate;
}
function goSeeInfoAnimal(id){
    window.location.href = '/admin/infoAnimal/show/'+id;
}



const confirmDeleteinfoAnimalBtn = document.getElementById('confirm-delete-infoAnimal-btn');
confirmDeleteinfoAnimalBtn.addEventListener('click', deleteInfoAnimal);

async function deleteInfoAnimal() {
    try {
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');
        let targetId = document.getElementById('infoAnimal-id').value;        
        const response = await fetch(`/admin/infoAnimal/delete/${targetId}`, {
            method: 'DELETE',
            headers: myHeaders,
        });
        if (response.ok) {
            const result = await response.json();
            getAllInfoAnimals();
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

const loaderGif=document.querySelector('.loaderGif');
const tableHead=document.querySelector('.tableHead');


async function getInfoAnimal($id){
    loaderGif.classList.remove('d-none');
    tableHead.classList.add('d-none')
    let myHeaders=new Headers();
    myHeaders.append('Content-Type', 'application/json');
    await fetch('/infoanimal/animal/'+$id)
    .then(response => {
        if(response.ok){
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    
    })
    .then(result => {
        // console.log('Result:', result);
        let infoAnimalTableBody = document.getElementById('infoAnimalTableBody');
        infoAnimalTableBody.innerHTML = '';
        let infoAnimals = result;
        if(infoAnimals.length === 0){
            infoAnimalTableBody.innerHTML = '<p class="text-center">Aucun compte-rendu pour le moment. <i class="fa-solid fa-umbrella-beach"></i> </p>';
        }
        let row = document.createElement('tr');
        row.classList.add('infoAnimalRow');
        
        infoAnimals.forEach(infoAnimal=>{
            if(infoAnimal.auteur === null){
                infoAnimal.auteur = {email: 'Utilisateur supprimé'};
            }
            row.setAttribute('data-animal-id', $id);
            row.setAttribute('data-infoAnimal-date', toYMD(infoAnimal.createdAt));
            row.innerHTML = `
            <td>${infoAnimal.id}</td>
            <td>${toYMD(infoAnimal.createdAt)}</td>
            <td>${infoAnimal.animal.prenom}</td>
            <td>${infoAnimal.auteur.email}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu mb-2" aria-labelledby="dropdownMenuButton">    
                        <li class="btn btn-danger mb-1" id="delete-infoAnimal" data-bs-toggle="modal" data-bs-target="#deleteInfoAnimalModal" data-infoAnimal-id="${infoAnimal.id}"><i class="fa-solid fa-trash"></i></li>
                        <li class="btn btn-info  mb-1" onClick="goSeeInfoAnimal(${infoAnimal.id})"><i class="fa-regular fa-eye"></i></li>
                    </div> 
                </div>
            </td>
            `;
            infoAnimalTableBody.appendChild(row);
            row = document.createElement('tr');
            row.classList.add('infoAnimalRow');
        });
        const btndelteinfoAnimals = document.querySelectorAll('[data-infoAnimal-id]');
        btndelteinfoAnimals.forEach(button=>{
            button.addEventListener('click', function(){
            const infoAnimalId = button.getAttribute('data-infoAnimal-id');
            const infoAnimalIdContainer = document.getElementById('infoAnimal-id');
            infoAnimalIdContainer.value = infoAnimalId;
            });
        });
        
    });
    loaderGif.classList.add('d-none');
    tableHead.classList.remove('d-none');
}




const animalSelect = document.getElementById('animal-select');
const dateSelect = document.getElementById('date-select');
animalSelect.addEventListener('change', function() {
    applyinfoAnimalFilters();
    getInfoAnimal(animalSelect.value);
    console.log('Getting infoAnimals for animal ID:', animalSelect.value);
});

dateSelect.addEventListener('change', applyinfoAnimalFilters);
applyinfoAnimalFilters();


/*--------------------------Services--------------------------*/
const servicesContainer  = document.getElementById('services-container');
const servicesBtns = document.querySelectorAll('.servicesBtn');

servicesBtns.forEach(button => button.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    getAllServices();
    servicesContainer.classList.remove('d-none');
    button.classList.add('active');
}));

async function getAllServices() {
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    await fetch('/services/all')
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Erreur');
            }
        })
        .then(result => {
            let servicesList = document.getElementById('servicesList');
            servicesList.innerHTML = '';
            let services = result;
            if (services.length === 0) {
                servicesList.innerHTML = '<p class="text-center">Aucun service à afficher <i class="fa-solid fa-umbrella-beach"></i> </p>';
            }
            let serviceTableBody = document.getElementById('servicesList');
            serviceTableBody.innerHTML = '';
            services.forEach(service => {
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td>${service.id}</td>
                    <td>${service.nom}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" 
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu mb-2" aria-labelledby="dropdownMenuButton">    
                                <li class="btn btn-danger mb-1" id="delete-service" data-bs-toggle="modal" data-bs-target="#deleteServiceModal" 
                                    data-delete-service-id="${service.id}"><i class="fa-solid fa-trash"></i></li>
                                <li class="btn btn-primary  mb-1" onClick="goEditService(${service.id})"><i class="fa-solid fa-pencil"></i></li>
                                <li class="btn btn-info  mb-1" onClick="goSeeService(${service.id})"><i class="fa-regular fa-eye"></i></li>
                            </div> 
                        </div>
                    </td>
                `;
                serviceTableBody.appendChild(row);
            });
            const deleteServiceBtns = document.querySelectorAll('[data-delete-service-id]');
            deleteServiceBtns.forEach(button => {
                button.addEventListener('click', function () {
                    const serviceId = button.getAttribute('data-delete-service-id');
                    const serviceIdContainer = document.getElementById('service-id');
                    serviceIdContainer.value = serviceId;
                });
            });
        })
        .catch(error => console.log(error));
    
}

// Supprimer un service:

const deleteServiceBtns=document.querySelectorAll('[data-delete-service-id]');
deleteServiceBtns.forEach(button=>{
    console.log('deleteServiceBtns', button);
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
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        getAllServices();
    })
    .catch(error => console.log(error), getAllServices());
}


function goSeeService($id){
    window.location.href = '/services/show/'+$id;
}
function goEditService($id){
    window.location.href = '/admin/services/edit/'+$id;
}


/*----------------- Horaires ----------------- */
const horairesContainer = document.getElementById('horaires-container');   
const horairesBtns = document.querySelectorAll('.horairesBtn'); 

horairesBtns.forEach(button => button.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    horairesContainer.classList.remove('d-none');
    button.classList.add('active');
}));

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

    let isOuvert=$('#isOuvert').is(':checked')  ? true:false;
    let raw=JSON.stringify({
        "ouverture": document.getElementById('HOuverture').value,
        "fermeture": document.getElementById('HFermeture').value,
        "ouvert": isOuvert
    
    })
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
const contactBtns = document.querySelectorAll('.contactBtn');

contactBtns.forEach(button => button.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    getAllDemandes();
    contactContainer.classList.remove('d-none');
    button.classList.add('active');
}));


async function getAllDemandes(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    await fetch('/contact/all')
    .then(response => {
        if(response.ok){
            return response.json();
        } else {
            throw new Error('Erreur');
            window.location.reload();
        }
    })
    .then(result => {
        let demandesList = document.getElementById('demandesList');
        demandesList.innerHTML = '';
        let demandes = result;
        if(demandes.length === 0){
            demandesList.innerHTML = '<p class="text-center mt-5">Aucune demande à afficher <i class="fa-solid fa-umbrella-beach"></i> </p>';
        }
        let row = document.createElement('div');
        row.classList.add('row');
        demandes.forEach(demande=>{
            let card = document.createElement('div');
            card.classList.add('col-12');
            card.classList.add('card');
            card.classList.add('demande-card');
            card.classList.add('mb-5')
            card.setAttribute('data-demande-status', demande.answered);
            card.setAttribute('data-demande-date', toYMD(demande.created_at));
            card.setAttribute('data-demande-id', demande.id);
            card.innerHTML = `
                <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">${demande.titre}</h5>
                <p class="text-muted">${toYMD(demande.created_at)}</p>
            </div>
            <div class="card-body">  
                <p class="text-muted">${demande.mail}</p>                             
                <p class="card-text">${demande.message}</p>
            </div>
            <div class="card-footer mb-5">
                <button type="button" class="btn btn-primary actionBtn" data-bs-toggle="modal" data-bs-target="#repondreModal" data-demande-id="${demande.id}">Répondre</button>
                <button type="button" class="btn btn-danger actionBtn" data-bs-toggle="modal" data-bs-target="#deleteDemandeModal" data-demande-id="${demande.id}">Supprimer</button>
            </div>
            `;
            if (demande.answered) {
                card.querySelector('.card-footer').innerHTML = `
                <p class="text-muted">Répondu le ${formatDate(demande.answered_at)}</p>
                <button type="button" class="btn btn-danger actionBtn" data-bs-toggle="modal" data-bs-target="#deleteDemandeModal" data-demande-id="${demande.id}">Supprimer</button>
                `;               
            }
            demandesList.appendChild(card);
            let actionBtns = card.querySelectorAll('.actionBtn');
            actionBtns.forEach(button => button.addEventListener('click', function(){
                const demandeId = button.getAttribute('data-demande-id');
                const demandeIdContainer = document.getElementById('demandeId');
                demandeIdContainer.value = demandeId;
            }));           
        });
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const year = date.getFullYear().toString().slice(-2);
    return `${day}-${month}-${year}`;
}

function toYMD(dateISO){
    let date = new Date(dateISO);
    let year = date.getFullYear();
    let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Month is 0-indexed, so add 1
    let day = date.getDate().toString().padStart(2, '0');
    let formattedDate = `${year}-${month}-${day}`;
    return formattedDate;
}


// Répondre à une demande de contact

const sendResponseBtn = document.getElementById('btnConfirmRepondre');
sendResponseBtn.addEventListener('click', sendResponse);

async function sendResponse() {
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let dataForm = new FormData(repondreForm);
    let targetId = document.getElementById('demandeId').value;
    let raw = JSON.stringify({
        "response": dataForm.get('reponse')
    });
    let requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    };
    try {
        let response = await fetch(`/admin/demande/repondre/${targetId}`, requestOptions);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        // Handle success
        getAllDemandes();
    } catch (error) {
        // Handle error
        console.error('Error:', error);
    }
}

const deleteDemandeBtn = document.getElementById('btnConfirmDeleteDemande');
deleteDemandeBtn.addEventListener('click', deleteDemande);
// Supprimer une demande de contact
async function deleteDemande() {
    try {
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');
        let targetId = document.getElementById('demandeId').value;
        const response = await fetch(`/admin/demande/delete/${targetId}`, {
            method: 'DELETE',
            headers: myHeaders,
        });
        if (response.ok) {
            getAllDemandes();
            return await response.json();
        } else {
            throw new Error('Erreur');
        }
    } catch (error) {
        alert('Une erreur est survenue. Veuillez réessayer plus tard.');
    }
}





// // Filtrer les demandes de contact
// function applyDemandeContactFilter(){
//     const targetedStatus = document.getElementById('demandeStatusSelect').value;
//     const targetedDate = document.getElementById('demande-date-select').value;
//     const demandeEntry = document.querySelectorAll('.demande-card');    
//     demandeEntry.forEach(item => {
//         const status = item.getAttribute('data-demande-status') === 'true' || item.getAttribute('data-demande-status') === ''; // Modifier cette ligne
//         let statusMatch;
//         if (targetedStatus === '*') {
//             statusMatch = true; // Si '*' est sélectionné, toutes les demandes sont considérées comme correspondantes
//         } else {
//             statusMatch = (targetedStatus === '1' && status) || (targetedStatus === '0' && !status); // Inverser la comparaison
//         }
//         const dateMatch = (targetedDate === '') || (item.getAttribute('data-demande-date') === targetedDate);
//         if (statusMatch && dateMatch) {
//             item.classList.remove('d-none');
//         } else {
//             item.classList.add('d-none');
//         }
//     });
// }
// const demandeStatusSelect = document.getElementById('demandeStatusSelect');
// demandeStatusSelect.addEventListener('change', applyDemandeContactFilter);

// const demandeDateSelect = document.getElementById('demande-date-select');
// demandeDateSelect.addEventListener('change', applyDemandeContactFilter);

// applyDemandeContactFilter();

/*----------------- Consultations des animaux -----------------*/

const consultationContainer = document.getElementById('consultationContainer');
const consultationContainerBtns = document.querySelectorAll('.consultationContainerBtn')

consultationContainerBtns.forEach(button => button.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    button.classList.add('active');
    consultationContainer.classList.remove('d-none');
}));




/*------------------Avis Clients------------------*/

const avisBtns = document.querySelectorAll('.avisBtn');
const avisContainer = document.getElementById('avisContainer');

avisBtns.forEach(button => button.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    button.classList.add('active');
    avisContainer.classList.remove('d-none');
    getNonValidatedReviews();
}));

async function getNonValidatedReviews(){
    try {
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');
        await fetch('/admin/avis/getNonValidated')
        .then(response => {
            if(response.ok){
                return response.json();
            } else {
                throw new Error('Erreur');
            }
        })
        .then(result => {
            let avisContainer = document.getElementById('avisContainer');
            let avisList = document.getElementById('avisList');
            let avis = result;
            avisList.innerHTML = '';
            if(avis.length === 0){
                avisList.innerHTML = '<p class="text-center">Aucun avis à afficher <i class="fa-solid fa-umbrella-beach"></i> </p>';
            }
            avis.forEach(avis=>{
                let card = document.createElement('div');
                card.classList.add('col-12');
                card.classList.add('card');
                card.innerHTML = `
                <div class="card-header">
                    ${avis.pseudo}
                </div>
                <div class="card-body">
                    <p class="card-text">${avis.note}</p>
                    <p class="card-text">${avis.Avis_content}</p>
                    <p class="card-text text-muted">${formatDate(avis.createdAt)}</p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" onclick="validerAvis(${avis.id})">Valider</button>
                    <button class="btn btn-danger" onclick="supprimerAvis(${avis.id})">Supprimer</button>
                </div>
                `;
                avisList.appendChild(card);
            }
            )
        })
    } catch (error) {
        console.log(error);
    }
}

async function validerAvis($id) {
    try {
        let myHeaders = new Headers(); 
        myHeaders.append('Content-Type', 'application/json');
        let requestOptions = {
            method:'POST',
            headers:myHeaders,
            redirect:'follow'
        };
        const response = await fetch('/admin/avis/valider/' + $id, requestOptions);
        if (response.status === 200) {
            getNonValidatedReviews();
        } else {
            console.log('Avis non validé');
        }
        const result = await response.json();
    } catch(error) {
        console.log('error', error);
    }
}

async function supprimerAvis($id) {
    try {
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');
        let requestOptions = {
            method: 'DELETE',
            headers: myHeaders,
            redirect: 'follow'
        };
        const response = await fetch('/admin/avis/delete/' + $id, requestOptions);
        if (response.status === 200) {
            getNonValidatedReviews();
        } else {
            console.log('Avis non supprimé');
        }
        const result = await response.json();
    } catch(error) {
        console.log('error', error);
    }
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
    avisContainer.classList.add('d-none');

    
}



/* Remove .active class from the sidebar */

function FlushActive(){
    userBtns.forEach(button => button.classList.remove('active'));
    habitatBtns.forEach(button => button.classList.remove('active'));
    animalBtns.forEach(button => button.classList.remove('active'));
    infoAnimalBtns.forEach(button => button.classList.remove('active'));
    servicesBtns.forEach(button => button.classList.remove('active'));
    horairesBtns.forEach(button => button.classList.remove('active'));
    contactBtns.forEach(button => button.classList.remove('active'));
    consultationContainerBtns.forEach(button => button.classList.remove('active'));
    avisBtns.forEach(button => button.classList.remove('active'));
}


/* Hide Phone Menu */
const sidebarCollapse = document.getElementById('sidebarCollapse');

sidebarCollapse.addEventListener('hidden.bs.collapse', function () {
    this.setAttribute('aria-hidden', 'true');
});