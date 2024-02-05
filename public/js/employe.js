const BtnValider = document.getElementById('BtnValider');
const BtnSupprimer = document.getElementById('deleteAvis');




BtnValider.addEventListener('click', validateAvis);
BtnSupprimer.addEventListener('click', deleteAvis);


/*-----------Validation / Suppression avis 05/02/2024 ------------------ */
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

