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
            // Create card container
            let card = document.createElement('div');
            card.classList.add('card', 'col-lg-3', 'col-md-12', 'col-sm-12', 'mt-1');
            
            // Create card header
            let cardHeader = document.createElement('div');
            cardHeader.classList.add('card-header');
            let cardTitle = document.createElement('h5');
            cardTitle.classList.add('card-title');
            cardTitle.textContent = animal.prenom;
            cardHeader.appendChild(cardTitle);
            
            // Create card body
            let cardBody = document.createElement('div');
            cardBody.classList.add('card-body');
            let cardImg = document.createElement('img');
            cardImg.src = `/images/animal/${animal.imageName}`;
            cardImg.classList.add('card-img-top', 'animal-img');
            cardImg.alt = `photo de ${animal.prenom}`;
            cardBody.appendChild(cardImg);
            
            // Create card footer with dropdown menu
            let cardFooter = document.createElement('div');
            cardFooter.classList.add('card-footer');
            
            let dropdown = document.createElement('div');
            dropdown.classList.add('dropdown');
            
            let dropdownButton = document.createElement('button');
            dropdownButton.classList.add('btn', 'btn-secondary', 'dropdown-toggle');
            dropdownButton.type = 'button';
            dropdownButton.id = 'dropdownMenuButton';
            dropdownButton.setAttribute('data-bs-toggle', 'dropdown');
            dropdownButton.setAttribute('aria-haspopup', 'true');
            dropdownButton.setAttribute('aria-expanded', 'false');
            dropdown.appendChild(dropdownButton);
            
            let dropdownMenu = document.createElement('div');
            dropdownMenu.classList.add('dropdown-menu');
            dropdownMenu.setAttribute('aria-labelledby', 'dropdownMenuButton');
            
            // "Voir" button
            let seeAnimalBtn = document.createElement('li');
            seeAnimalBtn.classList.add('dropdown-item');
            seeAnimalBtn.textContent = 'Voir';
            seeAnimalBtn.onclick = () => goSeeAnimal(animal.id);
            dropdownMenu.appendChild(seeAnimalBtn);
            
            // "Supprimer" button
            let deleteAnimalBtn = document.createElement('li');
            deleteAnimalBtn.classList.add('dropdown-item');
            deleteAnimalBtn.textContent = 'Supprimer';
            deleteAnimalBtn.setAttribute('data-bs-toggle', 'modal');
            deleteAnimalBtn.setAttribute('data-bs-target', '#delete-animal-Modal');
            deleteAnimalBtn.setAttribute('delete-animal-id', animal.id);
            dropdownMenu.appendChild(deleteAnimalBtn);
            
            // "Modifier" button
            let editAnimalBtn = document.createElement('li');
            editAnimalBtn.classList.add('dropdown-item');
            editAnimalBtn.textContent = 'Modifier';
            editAnimalBtn.onclick = () => goEditAnimal(animal.id);
            dropdownMenu.appendChild(editAnimalBtn);
            
            dropdown.appendChild(dropdownMenu);
            cardFooter.appendChild(dropdown);
            
            // Append header, body, and footer to card
            card.appendChild(cardHeader);
            card.appendChild(cardBody);
            card.appendChild(cardFooter);
            
            // Append card to animalsList
            animalsList.appendChild(card);
            
            // Handle the delete button separately to set the modal data
            let deleteAnimalBtns = document.querySelectorAll('[delete-animal-id]');  
            deleteAnimalBtns.forEach(button => button.addEventListener('click', function() {
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