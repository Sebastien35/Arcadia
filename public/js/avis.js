const pseudoInput = document.getElementById('pseudoInput');
const noteInput = document.getElementById('noteInput');
const avisContentInput = document.getElementById('avisContentInput');
// const btnCreate = document.getElementById('btnCreate');

// btnCreate.addEventListener('click', createAvis);

// pseudoInput.addEventListener('keyup', validateForm);
// noteInput.addEventListener('keyup', validateForm);
// avisContentInput.addEventListener('keyup', validateForm);


// /*------------- Validation User Input-------------  */

// /* ValidateForm 02/02/2024 */
// function validateForm(){
//     const pseudoOk = validateRequired(pseudoInput);
//     const noteOk = validateNote(noteInput);
//     const avisContentOk = validateRequired(avisContentInput);
//     if(pseudoOk && noteOk && avisContentOk){
//         btnCreate.disabled = false;
//     }else{
//         btnCreate.disabled = true;
//     }
// }


// /* Validate Required 02/02/2024 */
// function validateRequired(input){
//     if(input.value != '' && input.value.length > 3){
//         input.classList.add("is-valid");
//         input.classList.remove("is-invalid"); 
//         return true;
//     }
//     else{
//         input.classList.remove("is-valid");
//         input.classList.add("is-invalid");
//         return false;
//     }
// }
// /* Validate Note 02/02/2024 */
// function validateNote(input){
//     if(input.value != '' && input.value >= 0 && input.value <= 5){
//         input.classList.add("is-valid");
//         input.classList.remove("is-invalid"); 
//         return true;
//     }
//     else{
//         input.classList.remove("is-valid");
//         input.classList.add("is-invalid");
//         return false;
//     }
// }

/* create Avis 02/02/2024*/
// function createAvis(){
//     let dataForm = new FormData(createAvisForm);
//     let myHeaders = new Headers();
//     // Permet de récupérer un integer et non un string
//     let note = parseInt(dataForm.get('note'));

//     myHeaders.append("Content-Type", "application/json");

//     let raw=JSON.stringify({
//         "pseudo": dataForm.get('pseudo'),
//         "note": note,
//         "Avis_content": dataForm.get('Avis_content')

//     })
//     let requestOptions={
//         method:'POST',
//         headers: myHeaders,
//         body:raw,
//         redirect:'follow'

//     };
//     console.log('requestOptions',requestOptions, 'raw', raw)
//     fetch("/avis/create",requestOptions)
//     .then(response=>{
//         if(response.status === 201){
//             window.location.href = "/avis";
//         }else{
//             throw new Error('Erreur, statut : ' + response.status);
//         }

//     })
//     .then(result=>{
//         alert('Merci d\' avoir partagé votre avis,' + dataForm.get('pseudo') + ' !');
//         window.location.reload();
//     })
//     .catch(error=>{
//         console.error('Error:',error);
//     });
// }


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