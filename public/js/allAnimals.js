const btnAnimals = document.querySelectorAll('.animalBtn');
btnAnimals.forEach(button=>button.addEventListener('click', getAnimals));

async function getAnimals(){
    console.log('Fetching animals...');
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
        let animalsList = document.getElementById('animalsList');
        animalsList.innerHTML = '';
        animals.forEach(animal => {
        let card = document.createElement('div');
        card.classList.add('card');
        card.classList.add('col-lg-3')
        card.classList.add('col-md-12')
        card.classList.add('col-sm-12')
        card.classList.add('mt-1')
        card.innerHTML = `
            <div class="card-header">
                <h5 class="card-title"></h5>${animal.prenom}</h5>
            </div>
            <div class="card-body">
                <img src="/images/animal/${animal.imageName}" class="card-img-top animal-img" alt="photo de ${animal.prenom}">
            </div>
            <div class="card-footer">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li class="dropdown-item" id="show-animal-btn" data-animal-id="{{ animal.id }}" onclick="goSeeAnimal(${animal.id})">Voir</li>
                        <li class="dropdown-item" id="delete-animal-btn" data-bs-toggle="modal" data-bs-target="#delete-animal-Modal" delete-animal-id="${animal.id}">Supprimer</li>
                        <li class="dropdown-item" id="edit-animal-btn"  data-animal-id="{{ animal.id }}" onclick="goEditAnimal(${animal.id})">Modifier</li>
                    </div> 
                </div>
            </div> 
            `;
        animalsList.appendChild(card);
        let deleteAnimalBtns=document.querySelectorAll('[delete-animal-id]');  
        deleteAnimalBtns.forEach(button=>button.addEventListener('click', function(){
            let animalId = button.getAttribute('delete-animal-id');
            let animalIdContainer = document.getElementById('delete-animal-id');
            animalIdContainer.value = animalId;
        }));
        });
    }
    catch (error) {
        console.log('Error: ', error);
    }
}