document.addEventListener('DOMContentLoaded', async function() {
    try {
        let animalId = document.getElementById('animalId').value;
        let myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");
        const response = await fetch('/animal/visit/' + animalId, {
            method: 'POST',
            headers: myHeaders,
            redirect: 'follow'
        });
        if (response.ok) {
            const data = await response.json();
        } else {
            console.log('Erreur lors de la requête : ', response.status);
        }
    } catch(error) {
        console.log('Une erreur est survenue : ', error);
    }
});

