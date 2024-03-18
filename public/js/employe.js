/*-----------Validation / Suppression avis 05/02/2024 ------------------ */
const avisContainer = document.getElementById('avisContainer');
const BtnSupprimer = avisContainer.querySelectorAll('.BtnSupprimer');

if(BtnSupprimer.length > 0){
    BtnSupprimer.forEach(button=>{
        button.addEventListener('click', deleteAvis);
    });
};

async function validerAvis($id) {
    try {
        let myHeaders = new Headers(); 
        myHeaders.append('Content-Type', 'application/json');
        let requestOptions = {
            method:'POST',
            headers:myHeaders,
            redirect:'follow'
        };
        const response = await fetch('/employe/avis/valider/' + $id, requestOptions);
        if (response.status === 200) {
            console.log('Avis validé');
            window.location.reload();
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
        const response = await fetch('/employe/avis/delete/' + $id, requestOptions);
        if (response.status === 200) {
            console.log('Avis supprimé');
            window.location.reload();
        } else {
            console.log('Avis non supprimé');
        }
        const result = await response.json();
        console.log('result', result);
    } catch(error) {
        console.log('error', error);
    }
}

document.addEventListener('DOMContentLoaded', function(){
const avisList  = document.getElementById('avisList');
if(avisList.children.length === 0){
    avisList.innerHTML = '<p class="text-center">Aucun avis à afficher <i class="fa-solid fa-umbrella-beach"></i> </p>';
};
});




/*-----------Affichage avis 14/02/2024 ------------------ */

const avisBtns = document.querySelectorAll('.avisBtn');

avisBtns.forEach(button=>{button.addEventListener('click', function(){
    flushFeatures();
    FlushActive();
    button.classList.add('active');
    avisContainer.classList.remove('d-none');
    });
});


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

/* ------demandes de contact 05/03/2024 ------------------ */
const contactContainer = document.getElementById('contactContainer');
const contactBtns = document.querySelectorAll('.contactBtn');
contactBtns.forEach(button=>{
    button.addEventListener('click', function(){
        flushFeatures();
        FlushActive();
        button.classList.add('active');
        contactContainer.classList.remove('d-none');
    });
});

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
    } catch (error) {
        // Handle error
        console.error('Error:', error);
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

