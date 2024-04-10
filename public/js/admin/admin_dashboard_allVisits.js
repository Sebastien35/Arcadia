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
        visitTableBody.innerHTML = '';
        // Pour chaque visite, créer une ligne dans le tableau
        visits.forEach(visit => {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${visit.animalName}</td>
                <td>${visit.visits}</td>
            `;
            visitTableBody.appendChild(row);
        });
    } catch (error) {
        console.log('Error: ', error);
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