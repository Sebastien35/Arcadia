const serviceId = document.getElementById('serviceId');
const inputNom = document.getElementById('inputNom');
const inputDescription = document.getElementById('inputDescription');
const Btnedit = document.getElementById('Btnedit');

Btnedit.addEventListener('click', editService);
inputNom.addEventListener('keyup', validateRequired(inputNom));

function validateRequired(input){
    if(input.value==''||input.value==null||input.value==undefined||input.value.length<3){
        input.classList.add('is-invalid');
        return false;
    }else{
        input.classList.add('is-valid');
        return true;
    }
}


function editService() {
    let dataForm = new FormData(serviceUpdateForm);
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    let raw = JSON.stringify({
        "nom": dataForm.get('nom'),
        "description": dataForm.get('description')
    });

    let requestOptions = {
        method: 'PUT',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    };

    fetch("/admin/services/update/" + serviceId.value, requestOptions)
        .then(response => {
            if (response.status === 200) {
                return response.json();
            } else {
                throw new Error('Erreur');
            }
        })
        .then(result => {
            console.log(result);
            alert("Service modifié avec succès");
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle error
        });
}

