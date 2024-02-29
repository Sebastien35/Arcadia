// Script for the admin dashboard

/*---------------- Display User Container ------------------*/
const userContainer = document.getElementById('user-container');
const userBtn = document.getElementById('userBtn');

userBtn.addEventListener('click', function(){
    console.log('User button clicked');
    FlushFeatures();
    FlushActive();
    userContainer.classList.remove('d-none');
    userBtn.classList.add('active');
    
});

// Delete User:
document.addEventListener('DOMContentLoaded', function(){
    const deleteUserBtns = document.querySelectorAll('[data-user-id]');
    deleteUserBtns.forEach(button=>{
        button.addEventListener('click', function(){
            const userId = button.getAttribute('data-user-id');
            const userIdContainer = document.getElementById('user-id');
            userIdContainer.value = userId;
        });
    });
});

const confirmDeleteUserBtn = document.getElementById('confirm-delete-user-btn');
confirmDeleteUserBtn.addEventListener('click', deleteUser);

function deleteUser(){
    let targetId = document.getElementById('user-id').value; // Use 'user-id' instead of 'userId'
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    fetch(`/admin/user/delete/${targetId}`, { // Use template literal for URL
        method: 'DELETE',
        headers: myHeaders,
        redirect: 'follow'
    })
    .then(response => {
        if(response.ok){
            window.location.reload();
            return response.json();
        }else{
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => console.log(error));
}

// Edit User:
document.addEventListener('DOMContentLoaded', function(){
    const editUserBtns = document.querySelectorAll('[data-user-id]');
    editUserBtns.forEach(button=>{
        button.addEventListener('click', function(){
            const userId = button.getAttribute('data-user-id');
            const userIdContainer = document.getElementById('edit-user-id');
            userIdContainer.value = userId;
        });
    });
});

const confirmEditUserBtn = document.getElementById('confirm-edit-user-btn');
confirmEditUserBtn.addEventListener('click', editUser);

function editUser(){
    let targetId = document.getElementById('edit-user-id').value;
    let email = document.getElementById('edit-email').value;
    let role = [document.getElementById('edit-role').value]; // Convert role to array
    let plainPassword = document.getElementById('edit-plainPassword').value;

    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');

    let userData = {
        email: email,
        roles: role, 
        plainPassword: plainPassword
    };

    fetch(`/admin/user/edit/${targetId}`, {
        method: 'PUT',
        headers: myHeaders,
        body: JSON.stringify(userData), 
        redirect: 'follow'
    })
    .then(response => {
        if(response.ok){
            window.location.reload();
            return response.json();
        } else {
            throw new Error('Erreur');
        }
    })
    .then(result => {
        window.location.reload();
    })
    .catch(error => console.log(error));
}


/* ----------------- Habitat Container ----------------- */
const habitatContainer = document.getElementById('habitat-container');
const habitatBtn = document.getElementById('habitatBtn');

habitatBtn.addEventListener('click', function(){
    console.log('Habitat button clicked');
    FlushFeatures();
    FlushActive();
    habitatContainer.classList.remove('d-none');
    habitatBtn.classList.add('active');
});

/* -----------------Animal Container ----------------- */
const animalContainer = document.getElementById('animal-container');
const animalBtn = document.getElementById('animalBtn');

animalBtn.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    animalContainer.classList.remove('d-none');
    animalBtn.classList.add('active');
});


/*-----------------infoAnimal Container ----------------- */
const infoAnimalContainer = document.getElementById('info-animal-container');
const infoAnimalBtn = document.getElementById('infoAnimalBtn');

infoAnimalBtn.addEventListener('click', function(){
    FlushFeatures();
    FlushActive();
    infoAnimalContainer.classList.remove('d-none');
    infoAnimalBtn.classList.add('active');
});

// Filtrer infoAnimal par animal
const animalSelect = document.getElementById('animal-select');
animalSelect.addEventListener('change', function(){
    let animalId = animalSelect.value;
    let infoAnimalRow = document.querySelectorAll('.infoAnimalRow');
    if(animalId!=0){
        infoAnimalRow.forEach(row=>{
            if(row.getAttribute('data-animal-id') != animalId){
                row.classList.add('d-none');
            }else{
                row.classList.remove('d-none');
            }
        });
    }else{
        infoAnimalRow.forEach(row=>{
            row.classList.remove('d-none');
        });
    }
});

// Filtrer infoAnimal par date
const dateSelect = document.getElementById('date-select');
dateSelect.addEventListener('change', function(){
    console.log(dateSelect.value)
    let date = dateSelect.value;
    let infoAnimalRow = document.querySelectorAll('.infoAnimalRow');
    if(date!=null){
        infoAnimalRow.forEach(row=>{
            if(row.getAttribute('data-date') != date){
                row.classList.add('d-none');
            }else{
                row.classList.remove('d-none');
            }
        });
    }else{
        infoAnimalRow.forEach(row=>{
            row.classList.remove('d-none');
        });
    }
});



/* Hide Containers */

function FlushFeatures(){
    userContainer.classList.add('d-none');
    habitatContainer.classList.add('d-none');
    animalContainer.classList.add('d-none');
    infoAnimalContainer.classList.add('d-none');

    
}

/* Remove .active class from the sidebar */

function FlushActive(){
    userBtn.classList.remove('active');
    habitatBtn.classList.remove('active');
    animalBtn.classList.remove('active');
    infoAnimalBtn.classList.remove('active');
}