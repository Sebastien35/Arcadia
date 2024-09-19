const visitContainerBtns = document.querySelectorAll('.consultationContainerBtn')

visitContainerBtns.forEach(button=>button.addEventListener('click', getConsultations));
async function getConsultations(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
    };
    try {
        let response = await fetch('/admin/visites/all', requestOptions);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        let result = await response.json();
        let visits = result; // Assuming result directly contains the visits array
        
        let visitTableBody = document.getElementById('visitTable');
        // Mettre le tableau à 0
        while (visitTableBody.firstChild) {
            visitTableBody.removeChild(visitTableBody.firstChild);
        }

        // Pour chaque visite, créer une ligne dans le tableau
        visits.forEach(visit => {
            let row = document.createElement('tr');
            let animalNameCell = document.createElement('td');
            animalNameCell.textContent = visit.animalName;
            row.appendChild(animalNameCell);

            let visitsCell = document.createElement('td');
            visitsCell.textContent = visit.visits;
            row.appendChild(visitsCell);
            visitTableBody.appendChild(row);
        });
    } catch (error) {
        alert('Une erreur est survenue lors de la récupération des visites');
    }
}


/* Rechercher un animal */
const searchInput = document.getElementById('searchAnimal');
searchInput.addEventListener('input', function(){
    let searchValue = searchInput.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        let animalName = row.querySelector('td').textContent.toLowerCase();
        if (animalName.includes(searchValue)){
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});