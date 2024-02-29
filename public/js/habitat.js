const btnConfirmDelete = document.getElementById('btnConfirmDelete');
const btnConfirmEdit = document.getElementById('btnConfirmEdit');





/* -------- Transmettre id de l'habitat à supprimer / éditer  ---------*/
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('[data-habitat-id]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const habitatId = button.getAttribute('data-habitat-id');
            const habitatIdContainer = document.getElementById('habitatId');
            habitatIdContainer.textContent = habitatId;
        });
    });

});
btnConfirmDelete.addEventListener('click', deleteHabitat); 

async function deleteHabitat(){
    const habitatId = document.getElementById('habitatId').textContent;
    let myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    let requestOptions = {
        method : 'DELETE', 
        headers: myHeaders,
        redirect: 'follow'
    };
    fetch('/admin/habitats/delete/'+ habitatId , requestOptions)
        .then(response => {
            if (response.status === 200 | 202 | 204){
                window.location.reload();
                return response.json();
                
            } else {
                throw new Error('Erreur');
            }
        })
        .then(result => {
            console.log(result);
            alert("Habitat supprimé avec succès");
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle error
        });


    }
        
    






