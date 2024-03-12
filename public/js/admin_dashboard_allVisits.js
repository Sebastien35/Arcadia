const visitContainerbtn = document.getElementById('consultationContainerBtn')

visitContainerbtn.addEventListener('click', getConsultations);
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
        console.log(result);
        let visits = result; // Assuming result directly contains the visits array
        console.log(visits);
        let visitTableBody = document.getElementById('visitTable');
        // Clear existing table rows
        visitTableBody.innerHTML = '';
        // Iterate over visits and create table rows
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
