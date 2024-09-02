/*---------------- Display User Container ------------------*/
const userContainer = document.getElementById('user-container');
const userBtns = document.querySelectorAll('.userBtn');
userBtns.forEach(button => button.addEventListener('click', function() {
    FlushFeatures();
    FlushActive();
    getNonAdminUsers() 
    userContainer.classList.remove('d-none');
    button.classList.add('active');
}));

async function getNonAdminUsers() {
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    
    try {
        let response = await fetch('/admin/user/nonAdmins', { headers: myHeaders });
        
        if (!response.ok) {
            throw new Error('Erreur');
        }
        
        let users = await response.json();
        let userTableBody = document.getElementById('userTableBody');
        while (userTableBody.firstChild) {
            userTableBody.removeChild(userTableBody.firstChild);
        }
        
        if (users.length === 0) {
            let noUsersMessage = document.createElement('p');
            noUsersMessage.classList.add('text-center');
            noUsersMessage.innerText = 'Aucun utilisateur à afficher';
            userTableBody.appendChild(noUsersMessage);
            return;
        }

        users.forEach(user => {
            // Create table row
            let row = document.createElement('tr');
            row.classList.add('userRow');
            row.setAttribute('data-user-id', user.id);

            // Create cells
            let idCell = document.createElement('td');
            idCell.textContent = user.id;

            let emailCell = document.createElement('td');
            emailCell.textContent = user.email;

            let rolesCell = document.createElement('td');
            rolesCell.textContent = user.roles;

            // Create action cell with dropdown
            let actionCell = document.createElement('td');
            let dropdown = document.createElement('div');
            dropdown.classList.add('dropdown');

            let dropdownButton = document.createElement('button');
            dropdownButton.classList.add('btn', 'btn-secondary', 'dropdown-toggle');
            dropdownButton.type = 'button';
            dropdownButton.setAttribute('data-bs-toggle', 'dropdown');
            dropdownButton.setAttribute('aria-haspopup', 'true');
            dropdownButton.setAttribute('aria-expanded', 'false');

            let dropdownMenu = document.createElement('div');
            dropdownMenu.classList.add('dropdown-menu', 'mb-2');

            // Delete button
            let deleteButton = document.createElement('li');
            deleteButton.classList.add('btn', 'btn-danger', 'mb-1');
            deleteButton.setAttribute('data-bs-toggle', 'modal');
            deleteButton.setAttribute('data-bs-target', '#deleteUserModal');
            deleteButton.setAttribute('data-user-id', user.id);

            let iconDelete = document.createElement('i');
            iconDelete.classList.add('fa-solid', 'fa-trash');
            deleteButton.appendChild(iconDelete);


            // Edit button
            let editButton = document.createElement('li');
            editButton.classList.add('btn', 'btn-primary', 'mb-1');
            editButton.setAttribute('data-bs-toggle', 'modal');
            editButton.setAttribute('data-bs-target', '#editUserModal');
            editButton.setAttribute('data-user-id', user.id);
            
            let iconEdit = document.createElement('i');
            iconEdit.classList.add('fa-solid', 'fa-pencil');
            editButton.appendChild(iconEdit);


            // Append elements
            dropdownMenu.appendChild(deleteButton);
            dropdownMenu.appendChild(editButton);
            dropdown.appendChild(dropdownButton);
            dropdown.appendChild(dropdownMenu);
            actionCell.appendChild(dropdown);

            row.appendChild(idCell);
            row.appendChild(emailCell);
            row.appendChild(rolesCell);
            row.appendChild(actionCell);

            userTableBody.appendChild(row);
        });

        // Add event listeners for delete buttons
        const deleteUserBtns = document.querySelectorAll('[data-user-id]');
        deleteUserBtns.forEach(button => {
            button.addEventListener('click', function () {
                const userId = button.getAttribute('data-user-id');
                const userIdContainer = document.getElementById('user-id');
                userIdContainer.value = userId;
            });
        });

    } catch (error) {
        alert('Error: ', error);
    }
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
        .catch(error => alert(error));
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
    .catch(error => alert(error));
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
        alert(error);
    }
}

//Afficher commentaires

document.addEventListener('DOMContentLoaded', function() {
    let commentButtons = document.querySelectorAll('.commentsBt');
    commentButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            let commentsDiv = button.nextElementSibling;
            let isVisible = commentsDiv.classList.contains('d-none');
            if (isVisible) {
                commentsDiv.classList.remove('d-none');
            } else {
                commentsDiv.classList.add('d-none');
            }
        });
    });
});


//Suprresion des commentaires

async function deleteComment($id){  
    let confirmation = window.confirm('Voulez-vous \
        vraiment supprimer ce commentaire ?');
    if(!confirmation){
        return;
    }
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    await fetch(`/admin/comment/delete/${$id}`, {
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
        window.location.reload();
    })
    .catch(error => alert(error));
}
            






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
        alert(error);
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


// Récupérer par animal et ou par date:
const animalSelect = document.getElementById('animal-select')
const dateSelect = document.getElementById('date-select')


const searchBtn = document.getElementById('filter-infoAnimal-btn');
searchBtn.addEventListener('click', SearchUsingCriterias);



async function SearchUsingCriterias(){
    const TableauARemplir = document.getElementById('infoAnimalTableBody');
    while (TableauARemplir.firstChild) {
        TableauARemplir.removeChild(TableauARemplir.firstChild);
    }
    
    let selected_animal = animalSelect.value;
    let selected_date = dateSelect.value;

    let url = `/admin/infoAnimal/search?animal_id=${selected_animal}&date=${selected_date}`;

    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    loaderGif.classList.remove('d-none');
    tableHead.classList.add('d-none');
    const response = await fetch(url, {
        method: 'GET',
        headers: myHeaders,
    });
    if(response.ok){
        loaderGif.classList.add('d-none');
        tableHead.classList.remove('d-none')
        let data = await response.json();
        DisplayCRV(data);
    } else {
        loaderGif.classList.add('d-none');
        tableHead.classList.remove('d-none')
        alert('Une erreur est survenue');
    }
}

function DisplayCRV(data) {
    const TableauARemplir = document.getElementById('infoAnimalTableBody');
    while (TableauARemplir.firstChild) {
        TableauARemplir.removeChild(TableauARemplir.firstChild);
    }
    

    if (data.length === 0) {
        const noDataMessage = document.createElement('p');
        noDataMessage.classList.add('text-center');
        noDataMessage.innerText = 'Aucune consultation à afficher';
        TableauARemplir.appendChild(noDataMessage);
        return;
    }

    data.forEach(crv => {
        let row = document.createElement('tr');
        let date = new Date(crv.createdAt);

        // Création des cellules
        let idCell = document.createElement('td');
        idCell.textContent = crv.id;

        let dateCell = document.createElement('td');
        dateCell.textContent = date.toLocaleDateString();

        let prenomCell = document.createElement('td');
        prenomCell.textContent = crv.animal.prenom;

        let emailCell = document.createElement('td');
        emailCell.textContent = crv.auteur.email;

        // Création de la cellule des actions avec le dropdown
        let actionCell = document.createElement('td');
        let dropdown = document.createElement('div');
        dropdown.classList.add('dropdown');

        let dropdownButton = document.createElement('button');
        dropdownButton.classList.add('btn', 'btn-secondary', 'dropdown-toggle');
        dropdownButton.type = 'button';
        dropdownButton.setAttribute('data-bs-toggle', 'dropdown');
        dropdownButton.setAttribute('aria-haspopup', 'true');
        dropdownButton.setAttribute('aria-expanded', 'false');

        let dropdownMenu = document.createElement('div');
        dropdownMenu.classList.add('dropdown-menu', 'mb-2');
        dropdownMenu.setAttribute('aria-labelledby', 'dropdownMenuButton');

        // Bouton de suppression
        let deleteButton = document.createElement('li');
        deleteButton.classList.add('btn', 'btn-danger', 'mb-1');
        deleteButton.setAttribute('data-bs-toggle', 'modal');
        deleteButton.setAttribute('data-bs-target', '#deleteInfoAnimalModal');
        
        let deleteIcon = document.createElement('i');
        deleteIcon.classList.add('fa-solid', 'fa-trash');
        deleteButton.appendChild(deleteIcon);

        // Bouton pour voir les détails
        let seeButton = document.createElement('li');
        seeButton.classList.add('btn', 'btn-primary', 'mb-1');
        seeButton.setAttribute('onClick', `goSeeInfoAnimal(${crv.id})`);
        
        let iconView = document.createElement('i');
        iconView.classList.add('fa-solid', 'fa-eye');
        seeButton.appendChild(iconView);

        // Ajout des boutons au menu déroulant
        dropdownMenu.appendChild(deleteButton);
        dropdownMenu.appendChild(seeButton);

        // Ajout du bouton et du menu au dropdown
        dropdown.appendChild(dropdownButton);
        dropdown.appendChild(dropdownMenu);

        // Ajout du dropdown à la cellule d'actions
        actionCell.appendChild(dropdown);

        // Ajout des cellules à la ligne
        row.appendChild(idCell);
        row.appendChild(dateCell);
        row.appendChild(prenomCell);
        row.appendChild(emailCell);
        row.appendChild(actionCell);

        // Ajout de la ligne au tableau
        TableauARemplir.appendChild(row);
    });
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
        alert(error);
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
    try {
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');

        const response = await fetch('/services/all', { headers: myHeaders });
        if (!response.ok) {
            throw new Error('Erreur');
        }
        const services = await response.json();
        let servicesList = document.getElementById('servicesList');
        while (servicesList.firstChild) {
            servicesList.removeChild(servicesList.firstChild);
        }
        
        if (services.length === 0) {
            const noDataMessage = document.createElement('p');
            noDataMessage.classList.add('text-center');
            noDataMessage.innerText = 'Aucun service à afficher';
            servicesList.appendChild(noDataMessage);
            return;
        }
        services.forEach(service => {
            let row = document.createElement('tr');

            let idCell = document.createElement('td');
            idCell.textContent = service.id;

            let nameCell = document.createElement('td');
            nameCell.textContent = service.nom;

            let actionCell = document.createElement('td');
            let dropdown = document.createElement('div');
            dropdown.classList.add('dropdown');

            let dropdownButton = document.createElement('button');
            dropdownButton.classList.add('btn', 'btn-secondary', 'dropdown-toggle');
            dropdownButton.type = 'button';
            dropdownButton.setAttribute('data-bs-toggle', 'dropdown');
            dropdownButton.setAttribute('aria-haspopup', 'true');
            dropdownButton.setAttribute('aria-expanded', 'false');

            let dropdownMenu = document.createElement('div');
            dropdownMenu.classList.add('dropdown-menu', 'mb-2');
            dropdownMenu.setAttribute('aria-labelledby', 'dropdownMenuButton');

            let deleteButton = document.createElement('li');
            deleteButton.classList.add('btn', 'btn-danger', 'mb-1');
            deleteButton.setAttribute('data-bs-toggle', 'modal');
            deleteButton.setAttribute('data-bs-target', '#deleteServiceModal');
            deleteButton.setAttribute('data-delete-service-id', service.id);
            
            let iconDelete = document.createElement('i');
            iconDelete.classList.add('fa-solid', 'fa-trash');  
            deleteButton.appendChild(iconDelete);

            let editButton = document.createElement('li');
            editButton.classList.add('btn', 'btn-primary', 'mb-1');
            editButton.setAttribute('onClick', `goEditService(${service.id})`);
            let iconEdit = document.createElement('i');
            iconEdit.classList.add('fa-solid', 'fa-pencil');
            editButton.appendChild(iconEdit);

            let viewButton = document.createElement('li');
            viewButton.classList.add('btn', 'btn-info', 'mb-1');
            viewButton.setAttribute('onClick', `goSeeService(${service.id})`);
            
            let iconView = document.createElement('i');
            iconView.classList.add('fa-solid', 'fa-eye');
            viewButton.appendChild(iconView);


            dropdownMenu.appendChild(deleteButton);
            dropdownMenu.appendChild(editButton);
            dropdownMenu.appendChild(viewButton);

            dropdown.appendChild(dropdownButton);
            dropdown.appendChild(dropdownMenu);

            actionCell.appendChild(dropdown);
            row.appendChild(idCell);
            row.appendChild(nameCell);
            row.appendChild(actionCell);


            servicesList.appendChild(row);
        });
        const deleteServiceBtns = document.querySelectorAll('[data-delete-service-id]');
        deleteServiceBtns.forEach(button => {
            button.addEventListener('click', function () {
                const serviceId = button.getAttribute('data-delete-service-id');
                const serviceIdContainer = document.getElementById('service-id');
                serviceIdContainer.value = serviceId;
            });
        });

    } catch (error) {
        alert('Error:', error);
    }
}

// Supprimer un service:

const deleteServiceBtns=document.querySelectorAll('[data-delete-service-id]');
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
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        getAllServices();
    })
    .catch(error => alert(error), getAllServices());
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
    .catch(error => alert('Une erreur est survenue', error));

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


async function getAllDemandes() {
    try {
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');

        const response = await fetch('/contact/all', { headers: myHeaders });
        if (!response.ok) {
            throw new Error('Erreur');
            window.location.reload();
        }

        const demandes = await response.json();
        let demandesList = document.getElementById('demandesList');
        while (demandesList.firstChild) {
            demandesList.removeChild(demandesList.firstChild);
        }

        if (demandes.length === 0) {
            let noDemandesMessage = document.createElement('p');
            noDemandesMessage.classList.add('text-center', 'mt-5');
            noDemandesMessage.innerText = 'Aucune demande à afficher ';
            demandesList.appendChild(noDemandesMessage);
            return;
        }

        let row = document.createElement('div');
        row.classList.add('row');

        demandes.forEach(demande => {
            let card = document.createElement('div');
            card.classList.add('col-12', 'card', 'demande-card', 'mb-5');
            card.setAttribute('data-demande-status', demande.answered);
            card.setAttribute('data-demande-date', toYMD(demande.created_at));
            card.setAttribute('data-demande-id', demande.id);

            let cardHeader = document.createElement('div');
            cardHeader.classList.add('card-header', 'd-flex', 'justify-content-between');

            let cardTitle = document.createElement('h5');
            cardTitle.classList.add('card-title');
            cardTitle.textContent = demande.titre;

            let cardDate = document.createElement('p');
            cardDate.classList.add('text-muted');
            cardDate.textContent = toYMD(demande.created_at);

            cardHeader.appendChild(cardTitle);
            cardHeader.appendChild(cardDate);

            let cardBody = document.createElement('div');
            cardBody.classList.add('card-body');

            let mailInfo = document.createElement('p');
            mailInfo.classList.add('text-muted');
            mailInfo.textContent = demande.mail;

            let messageText = document.createElement('p');
            messageText.classList.add('card-text');
            messageText.textContent = demande.message;

            cardBody.appendChild(mailInfo);
            cardBody.appendChild(messageText);

            let cardFooter = document.createElement('div');
            cardFooter.classList.add('card-footer', 'mb-5');

            if (demande.answered) {
                let reponseInfo = document.createElement('p');
                reponseInfo.classList.add('text-muted');
                reponseInfo.textContent = `Répondu le ${formatDate(demande.answered_at)}`;

                let deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.classList.add('btn', 'btn-danger', 'actionBtn');
                deleteBtn.setAttribute('data-bs-toggle', 'modal');
                deleteBtn.setAttribute('data-bs-target', '#deleteDemandeModal');
                deleteBtn.setAttribute('data-demande-id', demande.id);
                deleteBtn.innerText = 'Supprimer';

                cardFooter.appendChild(reponseInfo);
                cardFooter.appendChild(deleteBtn);
            } else {
                let repondreBtn = document.createElement('button');
                repondreBtn.type = 'button';
                repondreBtn.classList.add('btn', 'btn-primary', 'actionBtn');
                repondreBtn.setAttribute('data-bs-toggle', 'modal');
                repondreBtn.setAttribute('data-bs-target', '#repondreModal');
                repondreBtn.setAttribute('data-demande-id', demande.id);
                repondreBtn.textContent = 'Répondre';

                let deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.classList.add('btn', 'btn-danger', 'actionBtn');
                deleteBtn.setAttribute('data-bs-toggle', 'modal');
                deleteBtn.setAttribute('data-bs-target', '#deleteDemandeModal');
                deleteBtn.setAttribute('data-demande-id', demande.id);
                deleteBtn.textContent = 'Supprimer';

                cardFooter.appendChild(repondreBtn);
                cardFooter.appendChild(deleteBtn);
            }

            card.appendChild(cardHeader);
            card.appendChild(cardBody);
            card.appendChild(cardFooter);
            row.appendChild(card);

            demandesList.appendChild(row);

            let actionBtns = card.querySelectorAll('.actionBtn');
            actionBtns.forEach(button => button.addEventListener('click', function () {
                const demandeId = button.getAttribute('data-demande-id');
                const demandeIdContainer = document.getElementById('demandeId');
                demandeIdContainer.value = demandeId;
            }));
        });

    } catch (error) {
        alerts('Error:', error);
    }
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
        alert('Error:', error);
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

async function getNonValidatedReviews() {
    try {
        const myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');
        
        const response = await fetch('/admin/avis/getNonValidated', { headers: myHeaders });
        if (!response.ok) {
            throw new Error('Erreur');
        }
        
        const result = await response.json();
        const avisContainer = document.getElementById('avisContainer');
        const avisList = document.getElementById('avisList');
        
        while(avisList.firstChild) {
            avisList.removeChild(avisList.firstChild);
        }
        
        if (result.length === 0) {
            const noReviewsMessage = document.createElement('p');
            noReviewsMessage.className = 'text-center';
            noReviewsMessage.innerText = 'Aucun avis à afficher';
            avisList.appendChild(noReviewsMessage);
        } else {
            result.forEach(avis => {
                const card = document.createElement('div');
                card.classList.add('col-12', 'card');
                
                // Create card header
                const cardHeader = document.createElement('div');
                cardHeader.classList.add('card-header');
                cardHeader.textContent = avis.pseudo;
                
                // Create card body
                const cardBody = document.createElement('div');
                cardBody.classList.add('card-body');
                
                const note = document.createElement('p');
                note.classList.add('card-text');
                note.textContent = avis.note;
                
                const content = document.createElement('p');
                content.classList.add('card-text');
                content.textContent = avis.Avis_content;
                
                const createdAt = document.createElement('p');
                createdAt.classList.add('card-text', 'text-muted');
                createdAt.textContent = formatDate(avis.createdAt);
                
                cardBody.append(note, content, createdAt);
                
                // Create card footer
                const cardFooter = document.createElement('div');
                cardFooter.classList.add('card-footer');
                
                const validateButton = document.createElement('button');
                validateButton.classList.add('btn', 'btn-success');
                validateButton.textContent = 'Valider';
                validateButton.addEventListener('click', () => validerAvis(avis.id));
                
                const deleteButton = document.createElement('button');
                deleteButton.classList.add('btn', 'btn-danger');
                deleteButton.textContent = 'Supprimer';
                deleteButton.addEventListener('click', () => supprimerAvis(avis.id));
                
                cardFooter.append(validateButton, deleteButton);
                
                card.append(cardHeader, cardBody, cardFooter);
                avisList.appendChild(card);
            });
        }
    } catch (error) {
        alert(error);
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
            alert('Une erreur est survenue');
        }
        const result = await response.json();
    } catch(error) {
        alert('error', error);
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
           alert('Une erreur est survenue');
        }
        const result = await response.json();
    } catch(error) {
        alert('error', error);
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


// Enlever .active quand on clique sur un btn

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


const sidebarCollapse = document.getElementById('sidebarCollapse');

sidebarCollapse.addEventListener('hidden.bs.collapse', function () {
    this.setAttribute('aria-hidden', 'true');
});