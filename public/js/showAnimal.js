/*-----------------------------------------------------------------------------------*/
/*---------------------Affichage des informations de l'animal------------------------*/
/*-----------------------------------------------------------------------------------*/

const infoBtn = document.querySelectorAll('.infoBtn');
const infoContainer = document.getElementById('infoContainer');

// userBtns.forEach(button => button.addEventListener('click', function() {
//     FlushFeatures();
//     FlushActive();
//     getNonAdminUsers() 
//     userContainer.classList.remove('d-none');
//     button.classList.add('active'); // Use 'button' instead of 'userBtn' because 'button' is the current button being clicked
// }));

infoBtn.forEach(button=>button.addEventListener('click', function(){
    flushActive();
    flushFeatures();
    infoContainer.classList.remove('d-none');
    button.classList.add('active');
}));


/*-----------------------Trier informations -----------------------------------*/
const dateInput = document.getElementById('dateInput');
const repas = document.querySelectorAll('.repas');
const repasDate = document.querySelectorAll('.repasdate');

dateInput.addEventListener('change', function() {
    // Quelle option a été sélectionnée ?
    let selectedOption = parseInt(dateInput.value);
    // Quelle est la date d'aujourd'hui ?
    let today = new Date();
    // Quelle est le premier jour de la semaine ?
    let weekStart = new Date();
    // Quel jour de la semaine est aujourd'hui ?
    weekStart.setDate(today.getDate() - today.getDay()); 
    // Quelle est le premier jour du mois ?
    let monthStart = new Date(today.getFullYear(), today.getMonth(), 1); 
    

    repas.forEach((repasItem) => {
        // Obtenir la date du repas
        let repasDateStr = repasItem.querySelector('.repasdate').textContent;
        let repasDateTime = new Date(repasDateStr);
        
        switch (selectedOption) {
            case 1: // Aujourd'hui
                if (isSameDay(repasDateTime, today)) {
                    repasItem.classList.remove('d-none');
                } else {
                    repasItem.classList.add('d-none');
                }
                break;
            case 2: // Cette semaine
                if (repasDateTime >= weekStart && repasDateTime <= today) {
                    repasItem.classList.remove('d-none');
                } else {
                    repasItem.classList.add('d-none');
                }
                break;
            case 3: // Ce mois
                if (repasDateTime.getFullYear() === today.getFullYear() &&
                    repasDateTime.getMonth() === today.getMonth()) {
                    repasItem.classList.remove('d-none');
                } else {
                    repasItem.classList.add('d-none');
                }
                break;
            default: // Tous les repas
                repasItem.classList.remove('d-none');
        }
    });
});

function isSameDay(date1, date2) {
    return date1.getFullYear() === date2.getFullYear() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getDate() === date2.getDate();
}


const infoAnimalDateInput = document.getElementById('infoAnimalDateInput');
    const infoAnimal = document.querySelectorAll('.infoAnimal');
    const infoAnimalDate = document.querySelectorAll('.infoAnimalDate');

    infoAnimalDateInput.addEventListener('change', function() {
        // Quelle option a été sélectionnée ?
        let selectedOption = parseInt(infoAnimalDateInput.value);
        // Quelle est la date d'aujourd'hui ?
        let today = new Date();
        // Quelle est le premier jour de la semaine ?
        let weekStart = new Date();
        // Quel jour de la semaine est aujourd'hui ?
        weekStart.setDate(today.getDate() - today.getDay()); 
        // Quelle est le premier jour du mois ?
        let monthStart = new Date(today.getFullYear(), today.getMonth(), 1); 
        
        infoAnimal.forEach((infoAnimalItem) => {
            // Obtenir la date du repas
            let infoAnimalDateStr = infoAnimalItem.querySelector('.infoAnimalDate').textContent;
            let infoAnimalDateTime = new Date(infoAnimalDateStr);
            
            switch (selectedOption) {
                case 1: // Aujourd'hui
                    if (isSameDay(infoAnimalDateTime, today)) {
                        infoAnimalItem.classList.remove('d-none');
                    } else {
                        infoAnimalItem.classList.add('d-none');
                    }
                    break;
                case 2: // Cette semaine
                    if (infoAnimalDateTime >= weekStart && infoAnimalDateTime <= today) {
                        infoAnimalItem.classList.remove('d-none');
                    } else {
                        infoAnimalItem.classList.add('d-none');
                    }
                    break;
                case 3: // Ce mois
                    if (infoAnimalDateTime.getFullYear() === today.getFullYear() &&
                        infoAnimalDateTime.getMonth() === today.getMonth()) {
                        infoAnimalItem.classList.remove('d-none');
                    } else {
                        infoAnimalItem.classList.add('d-none');
                    }
                    break;
                default: // Tous les repas
                    infoAnimalItem.classList.remove('d-none');
            }
        });
    });

    function isSameDay(date1, date2) {
        return date1.getFullYear() === date2.getFullYear() &&
            date1.getMonth() === date2.getMonth() &&
            date1.getDate() === date2.getDate();
    }


/*-----------------------------------------------------------------------------------*/
/*---------------------Affichage des images de l'animal------------------------------*/
/*-----------------------------------------------------------------------------------*/

const imageBtn = document.querySelectorAll('.imageBtn');
const imageContainer=document.getElementById('imageContainer');

imageBtn.forEach(button=>button.addEventListener('click', function(){
    flushActive();
    flushFeatures();
    // getAnimalImages();
    imageContainer.classList.remove('d-none');
    button.classList.add('active');
}));







// async function getAnimalImages(){
//     $animalId = document.getElementById('animalId').value;
//     await fetch('/animal/getImages/'+$animalId)
//     .then(response=>{
//         if(response.ok){
//             return response.json();
//         }else{
//             throw new Error('Erreur de chargement des images');
//         }
//     })
//     .then(result=>{
//         let imageList = document.getElementById('imageList');
//         imageList.innerHTML='';
//         let images = result;
//         if (images.length === 0) {
//             imageList.innerHTML = '<p class="text-center">Pas d\'images disponibles</p>';
//         }
//         images.forEach(image=>{
//             let imageElement = document.createElement('img');
//             imageElement.src = '/images/additionnal_images'+image.imageName;
//             imageElement.classList.add('img-fluid');
//             imageElement.classList.add('m-2');
//             imageList.appendChild(imageElement);
//         })
//     })
    
        
            
// }
    























function flushFeatures(){
    infoContainer.classList.add('d-none');
    imageContainer.classList.add('d-none');
}

function flushActive(){
    infoBtn.forEach(button=>button.classList.remove('active'));
    imageBtn.forEach(button=>button.classList.remove('active'));
}

function defaultBehavior(){
    infoBtn.forEach(button=>button.classList.add('active'));
    infoContainer.classList.remove('d-none');
}

defaultBehavior();

