


/*-----------Validation / Suppression avis 05/02/2024 ------------------ */
const avisContainer = document.getElementById('avisContainer');
const BtnValider = avisContainer.querySelectorAll('.BtnValider');
const BtnSupprimer = avisContainer.querySelectorAll('.BtnSupprimer');

if(BtnValider.length > 0){
    BtnValider.forEach(button=>{
        button.addEventListener('click', validateAvis);
    });
};

if(BtnSupprimer.length > 0){
    BtnSupprimer.forEach(button=>{
        button.addEventListener('click', deleteAvis);
    });
};

function validateAvis(){
    let dataForm = new FormData(validateAvisForm);
    let myHeaders = new Headers();
    let avisId = dataForm.get('id');
    
    myHeaders.append('Content-Type', 'application/json');

    let raw= JSON.stringify({
        "validation": "true"
    });
    let requestOptions = {
        method:'POST',
        headers:myHeaders,
        body:"raw",
        redirect:'follow'
    };
    fetch('/avis/valider/' + avisId, requestOptions)
    .then(response=>{
        if(response.status === 200){
            console.log('Avis validé');
            window.location.reload();
        }else{
            console.log('Avis non validé');
        }
    })
    .then(result=>{
        console.log('result', result)
        
    })
    .catch(error=>{
        console.log('error', error)
    });
    
}

function deleteAvis(){
    let dataForm = new FormData(DelAvisForm);
    let avisId = dataForm.get('id');
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let requestOptions = {
        method:'DELETE',
        headers:myHeaders,
        redirect:'follow'
    };
    fetch('/avis/delete/' + avisId, requestOptions)
    .then(response=>{
        console.log('avisId', avisId, 'response', response)
        if(response.status === 200){
            console.log('Avis supprimé');
            window.location.reload();
            
        }else{
            console.log('Avis non supprimé');
        }
    })
    .then(result=>{
        console.log('result', result)
        
    })
}
document.addEventListener('DOMContentLoaded', function(){
const avisList  = document.getElementById('avisList');
if(avisList.children.length === 0){
    avisList.innerHTML = '<p class="text-center">Aucun avis à afficher <i class="fa-solid fa-umbrella-beach"></i> </p>';
};
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



/*-----------Affichage avis 14/02/2024 ------------------ */

const avisBtn = document.getElementById('avisBtn');

avisBtn.addEventListener('click', showAvis);

function showAvis(){
    flushFeatures();
    FlushActive();
    avisBtn.classList.add('active')
    avisContainer.classList.remove('d-none');
    
}

/*-----------Affichage services 14/02/2024 ------------------ */
const servicesContainer = document.getElementById('servicesContainer');
const servicesBtn = document.getElementById('servicesBtn');

servicesBtn.addEventListener('click', showServices);

function showServices(){
    flushFeatures();
    FlushActive();
    servicesBtn.classList.add('active')
    servicesContainer.classList.remove('d-none');
}

/*-----------Affichage nourriture 15/02/2024 ------------------ */

const nourritureContainer = document.getElementById('foodContainer');
const nourritureBtn = document.getElementById('foodBtn');

nourritureBtn.addEventListener('click', showNourriture);

function showNourriture(){
    flushFeatures();
    FlushActive();
    nourritureBtn.classList.add('active');
    nourritureContainer.classList.remove('d-none');
}





/* Affichage des fonctionnalités de l'employé 14/02/2024 ------------------ */

function flushFeatures(){
    console.log('flushFeatures'); // debug
    avisContainer.classList.add('d-none');
    servicesContainer.classList.add('d-none');
    nourritureContainer.classList.add('d-none');

}
flushFeatures();

function FlushActive(){
    avisBtn.classList.remove('active');
    servicesBtn.classList.remove('active');
    nourritureBtn.classList.remove('active');
}
FlushActive();