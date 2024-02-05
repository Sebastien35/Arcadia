const pseudoInput = document.getElementById('pseudoInput');
const noteInput = document.getElementById('noteInput');
const avisContentInput = document.getElementById('avisContentInput');
const btnCreate = document.getElementById('btnCreate');

btnCreate.addEventListener('click', createAvis);

pseudoInput.addEventListener('keyup', validateForm);
noteInput.addEventListener('keyup', validateForm);
avisContentInput.addEventListener('keyup', validateForm);


/*------------- Validation User Input-------------  */

/* ValidateForm 02/02/2024 */
function validateForm(){
    const pseudoOk = validateRequired(pseudoInput);
    const noteOk = validateNote(noteInput);
    const avisContentOk = validateRequired(avisContentInput);
    if(pseudoOk && noteOk && avisContentOk){
        btnCreate.disabled = false;
    }else{
        btnCreate.disabled = true;
    }
}


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
/* Validate Note 02/02/2024 */
function validateNote(input){
    if(input.value != '' && input.value >= 0 && input.value <= 5){
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

/* create Avis 02/02/2024*/
function createAvis(){
    console.log("createAvis");
}