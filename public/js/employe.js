
/*-----------Affichage avis 14/02/2024 ------------------ */
const avisBtns = document.querySelectorAll('.avisBtn');
const avisContainer = document.getElementById('avisContainer');

avisBtns.forEach(button => button.addEventListener('click', function(){
    flushFeatures();
    FlushActive();
    button.classList.add('active');
    avisContainer.classList.remove('d-none');
    getNonValidatedReviews();
}));

/*-----------Validation / Suppression avis 05/02/2024 ------------------ */
async function getNonValidatedReviews(){
    try {
        let myHeaders = new Headers();
        myHeaders.append('Content-Type', 'application/json');
        await fetch('/employe/avis/getNonValidated')
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
            console.log('Avis validé');
            getNonValidatedReviews();
        } else {
            console.log('Avis non validé');
        }
        const result = await response.json();
        console.log('result', result);
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








/*-----------Affichage services 14/02/2024 ------------------ */
const servicesContainer = document.getElementById('servicesContainer');
const servicesBtns = document.querySelectorAll('.servicesBtn');

servicesBtns.forEach(button=>{
    button.addEventListener('click', function(){
        flushFeatures();
        FlushActive();
        button.classList.add('active');
        servicesContainer.classList.remove('d-none');
    }); 
});

/*---------------- Mise à jour service ------------------ */

document.addEventListener('DOMContentLoaded', function(){
    const updateServiceBtns = document.querySelectorAll('[data-service-id]');
    updateServiceBtns.forEach(button=>{
        button.addEventListener('click', function(){
            const serviceId = button.getAttribute('data-service-id');
            const serviceIdContainer = document.getElementById('serviceId');
            serviceIdContainer.value = serviceId; // Utilisez .value pour les éléments de formulaire
        });
    });
});

const updateServiceConfirmBtn = document.getElementById('btnConfirmEditService');
const editForm = document.getElementById('editServiceForm');
updateServiceConfirmBtn.addEventListener('click', updateService);


function updateService(){
    const serviceId = document.getElementById('serviceId').value;
    console.log(serviceId); // Remove !
    let dataForm = new FormData(editForm);
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let requestOptions = {
        method:'PUT',
        headers:myHeaders,
        body:JSON.stringify(Object.fromEntries(dataForm)),
        redirect:'follow'
    };
    fetch('/employe/services/edit/' + serviceId, requestOptions)
    .then(response=>{
        if(response.status === 200){
            console.log('Service modifié');
            window.location.reload();
        }else{
            console.log('Service non modifié');
        }
    })
    .then(result=>{
        console.log('result', result)
    })
    .catch(error=>{
        console.log('error', error)
    });
}

// Afficher le service depuis dropdown

function showService($id){
    window.location.href = '/services/show/' + $id;
}




/*-----------Affichage nourriture 15/02/2024 ------------------ */

const nourritureContainer = document.getElementById('foodContainer');
const nourritureBtns = document.querySelectorAll('.foodBtn');

nourritureBtns.forEach(button=>{
    button.addEventListener('click', function(){
        flushFeatures();
        FlushActive();
        button.classList.add('active');
        nourritureContainer.classList.remove('d-none');
    });
});

//*-----------demandes de contact 05/03/2024 ------------------ */
const contactContainer = document.getElementById('contactContainer');
const contactBtns = document.querySelectorAll('.contactBtn');

contactBtns.forEach(button => button.addEventListener('click', function(){
    flushFeatures();
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
            card.setAttribute('data-demande-date', demande.createdAt);
            card.setAttribute('data-demande-id', demande.id);
            card.innerHTML = `
                <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">${demande.titre}</h5>
                <p class="text-muted">${formatDate(demande.createdAt)}</p>
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
                <p class="text-muted">Répondu le ${formatDate(demande.answeredAt)}</p>
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
        console.log(error);
    }
}

/* Affichage des fonctionnalités de l'employé 14/02/2024 ------------------ */

function flushFeatures(){
    avisContainer.classList.add('d-none');
    servicesContainer.classList.add('d-none');
    nourritureContainer.classList.add('d-none');
    contactContainer.classList.add('d-none');
}
flushFeatures();

function FlushActive(){
    avisBtns.forEach(button=>{
        button.classList.remove('active');
    });
    servicesBtns.forEach(button=>{
        button.classList.remove('active');
    });
    nourritureBtns.forEach(button=>{
        button.classList.remove('active');
    });
    contactBtns.forEach(button=>{
        button.classList.remove('active');
    });
    
}
FlushActive();

