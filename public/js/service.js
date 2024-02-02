const serviceId = document.getElementById('serviceId');
const inputNom = document.getElementById('inputNom');
const inputDescription = document.getElementById('inputDescription');
const Btnedit = document.getElementById('Btnedit');
const Btndelete = document.getElementById('Btndelete');
const Btncreate = document.getElementById('Btncreate');

create_inputNom.addEventListener('keyup', validateForm);
create_inputDescription.addEventListener('keyup', validateForm);

Btnedit.addEventListener('click', editService);
Btndelete.addEventListener('click', deleteService);
Btncreate.addEventListener('click', createService);


/*------------- Validation User Input-------------  */

/* ValidateForm 02/02/2024 */
function validateForm(){
    const nomOk = validateRequired(create_inputNom);
    const descriptionOk = validateRequired(create_inputDescription);
    if(nomOk && descriptionOk){
        Btncreate.disabled = false;
    }else{
        Btncreate.disabled = true;
    }
}
validateForm();
/* Validate Required 02/02/2024 */
function validateRequired(input){
    if(input.value != '' && input.value.length > 3){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid"); 
        return true;
    }
    else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}
/* create Service 02/02/2024*/
function createService(){
    let dataForm = new FormData(createServiceForm);
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    let raw = JSON.stringify({
        "nom": dataForm.get('nom'),
        "description": dataForm.get('description')
    });

    let requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    };

    fetch("/admin/services/create", requestOptions)
        .then(response => {
            console.log("requestOptions : ", response);
            console.log("Response : ",response);
            if (response.status === 200) {
                return response.json();
            } else {
                throw new Error('Erreur');
            }
        })
        .then(result => {
            console.log(result);
            alert("Service créé avec succès");
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle error
        });

}


/* edit Service  02/02/2024 */
function testDeleteService(){
    alert("Would delete service with id: "+serviceId.value);
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

/* Delete Service 02/02/2024 */

function deleteService() {

    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    let requestOptions = {
        method: 'DELETE',
        headers: myHeaders,
        redirect: 'follow'
    };

    fetch("/admin/services/delete/" + serviceId.value, requestOptions)
        .then(response => {
            if (response.status === 200) {
                return response.json();
            } else {
                throw new Error('Erreur');
            }
        })
        .then(result => {
            console.log(result);
            alert("Service supprimé avec succès");
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle error
        });
}