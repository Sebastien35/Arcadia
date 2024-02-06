const btnEdit = document.getElementById('btnEdit');

btnEdit.addEventListener('click', editHoraire);

function editHoraire(){
    let dataForm = new FormData(editHoraireForm);
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let jourSelect = document.getElementById('jour');
    let id = jourSelect.value;
    let isOuvert=$('#isOuvert').is(':checked')  ? true:false;
    
    // Construct the JSON object
    let rawData = {
        "ouverture": dataForm.get('HOuverture'),
        "fermeture": dataForm.get('HFermeture'),
        "ouvert": isOuvert
    };
    
    // Convert the JSON object to a JSON string
    let raw = JSON.stringify(rawData);

    let requestOptions = {
        method:'PUT',
        headers:myHeaders,
        body:raw,
        redirect:'follow'
    };
    fetch('/admin/horaires/edit/' + id,requestOptions )
    .then(response=>{
        console.log(rawData);
        if(response.status === 200){
            console.log('Horaire modifié');
        } else {
            console.log('Horaire non modifié');
            console.log('response', response)
        }
    })
    .then(result=>{
        console.log('result', result)
    })
    .catch(error=>{
        console.log('error', error)
    });
}

/* Fonction pour convertir string en time */ 







/*---------------------------------------*/