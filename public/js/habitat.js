const btnCreateHabitat = document.getElementById('btnCreateHabitat');
const uploadImage = document.getElementById('create_inputImage');
const imagePreview = document.getElementById('create_imagePreview');
const create_nom = document.getElementById('create_inputNom');
const create_description = document.getElementById('create_inputDescription');

btnCreateHabitat.addEventListener('click', createHabitat);
uploadImage.addEventListener('change', validateUpload);



function createHabitat() {
    alert('createHabitat');
    let dataForm = new FormData(createHabitatForm);
    let myHeaders = new Headers();
    // Remove the Content-Type header as FormData will automatically set it
    let requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: dataForm,
        redirect: 'follow'
    };
    fetch('/admin/habitats/create', requestOptions)
        .then(response => {
            if (response.status === 200) {
                console.log('Habitat créé');
                console.log(dataForm.get('image'), dataForm.get('nom'), dataForm.get('description'));
            } else {
                console.log('Habitat non créé');
                console.log('response', response);
            }
        })
        .then(result => {
            console.log('result', result);
        })
        .catch(error => {
            console.log('error', error);
        });
}



/* Valider image */

function validateUpload(){
    var fuData = document.getElementById('create_inputImage');
    var FileUploadPath = fuData.value;
    var Extension = FileUploadPath.substring(
        FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (Extension == "png" || Extension == "jpeg" || Extension == "jpg") {
            if (fuData.files && fuData.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.add('d-block');
                    return true;
                }
                reader.readAsDataURL(fuData.files[0]);
            }

        } else {
            alert("Photo non acceptée, veuillez choisir une photo au format png, jpeg ou jpg");
            imagePreview.src = '';
            imagePreview.classList.add('d-none')
            return false;
        }
    }


/* Vérification formulaire */

function validateForm(){
    let nom = document.getElementById('create_inputNom');
    let description = document.getElementById('create_inputDescription');
    let Btncreate = document.getElementById('btnCreateHabitat');
    if(validateRequired(nom) && validateRequired(description) && validateUpload()){
        Btncreate.disabled = false;
    }else{
        Btncreate.disabled = true;
    }
}

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

create_nom.addEventListener('keyup', validateForm);
create_description.addEventListener('keyup', validateForm);

