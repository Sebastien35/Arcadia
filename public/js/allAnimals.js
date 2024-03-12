const btnAnimal = document.getElementById('animalBtn');
btnAnimal.addEventListener('click', getAnimals);

async function getAnimals(){
    let myHeaders = new Headers();
    myHeaders.append('Content-Type', 'application/json');
    let requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
    };
    try {
        let response = await fetch('/admin/animal/all', requestOptions);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        let result = await response.json();
        let animals = result; // Assuming result directly contains the animals array
        let animalTableBody = document.getElementById('animalTableBody');
        // Clear existing table rows
        animalTableBody.innerHTML = '';
        // Iterate over animals and create table rows
        animals.forEach(animal => {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${animal.id}</td>
                <td>${animal.prenom}</td>
                <td>${animal.race}</td>
                <td>
                    <a type="button" class="btn btn-info" href="/admin/animal/show/${animal.id}"><i class="fa-regular fa-eye"></i></a>
                    <button class="btn btn-primary" id="edit-animal-btn" onclick="window.location=('/admin/animal/update/'+ ${animal.id} )">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-danger delete-animal-btn" data-bs-toggle="modal" data-bs-target="#delete-animal-Modal" data-animal-id="${animal.id}">
                        <i class="fa-solid fa-user-minus"></i>
                    </button>
                </td>
            `;
            animalTableBody.appendChild(row);
            
            // Attach event listener to the delete button within the current row
            let deleteBtn = row.querySelector('.delete-animal-btn');
            deleteBtn.addEventListener('click', function() {
                const animalId = deleteBtn.getAttribute('data-animal-id');
                const animalIdContainer = document.getElementById('delete-animal-id');
                animalIdContainer.value = animalId;
            });
        });
    }
    catch (error) {
        console.log('Error: ', error);
    }
}