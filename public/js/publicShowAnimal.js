/*************************************************/
/*Fichier javascript pour /animal/show/:id*/
/*************************************************/

document.addEventListener('DOMContentLoaded', function() {

/********Afficher les informations de l'animal***************/

    let infoBtns = document.querySelectorAll('.infoBtn');
    let infoContainer = document.getElementById('infoContainer');

    infoBtns.forEach(button=>button.addEventListener('click', function(){
        flushFeatures();
        flushActive();
        button.classList.add('active');
        infoContainer.classList.remove('d-none');
    }));

/********Afficher la gallerie******************************/

    let gallerieBtns=document.querySelectorAll('.imageBtn');
    let gallerieContainer=document.getElementById('gallerie-container');

    gallerieBtns.forEach(button=>button.addEventListener('click', function(){
        flushFeatures();
        flushActive();
        getAnimalImages();
        button.classList.add('active');
        gallerieContainer.classList.remove('d-none');
    }));

    async function getAnimalImages(){
        let myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");
        let animalId=document.getElementById('animalId').value;
        let requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };
        await fetch('/animal/getImages/'+animalId, requestOptions)  
        .then(response=> {
            if(response.ok){
                return response.json();
            } else {
                throw new Error('Erreur de chargement des images');
            }
        })
        .then(result => {
            result=JSON.parse(result);
            let gallerie = document.getElementById('gallerie');
            gallerie.innerHTML = '';
            if(result.length===0 || result === null){
                let NoImagesText = document.createElement('h3');
                NoImagesText.textContent='Aucune image à afficher';
                gallerie.appendChild(NoImagesText);
                return;
            }
            let images = result;
        

            
            images.forEach(image => {
            let card = document.createElement('div');
            card.classList.add('card');
            card.classList.add('col-sm-12');
            card.classList.add('col-md-6');
            card.classList.add('col-lg-4');
            let cardImg = document.createElement('img');

            // Définissez les attributs de l'image
            cardImg.src = `/images/additionnal_images/${image.imageName}`;
            cardImg.classList.add('card-img-top');
            cardImg.alt = '...';

            // Ajoutez l'image à la carte
            card.appendChild(cardImg);
            gallerie.appendChild(card);
            });
        });
    }
        
    

    function flushFeatures(){
        infoContainer.classList.add('d-none');
        gallerieContainer.classList.add('d-none');
    }

    function flushActive(){
        infoBtns.forEach(button=>button.classList.remove('active'));
        gallerieBtns.forEach(button=>button.classList.remove('active'));
    }

    function defaultBehavior(){
        flushFeatures();
        flushActive();
        infoBtns.forEach(button=>button.classList.add('active'));
        infoContainer.classList.remove('d-none');
    }

    defaultBehavior();

});
