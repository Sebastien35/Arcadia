// Filtrer les demandes de contact
function applyDemandeContactFilter(){
    const targetedStatus = document.getElementById('demandeStatusSelect').value;
    const targetedDate = document.getElementById('demande-date-select').value;
    const demandeEntry = document.querySelectorAll('.demande-card');    
    demandeEntry.forEach(item => {
        const status = item.getAttribute('data-demande-status') === 'true' || item.getAttribute('data-demande-status') === ''; // Modifier cette ligne
        let statusMatch;
        if (targetedStatus === '*') {
            statusMatch = true; // Si '*' est sélectionné, toutes les demandes sont considérées comme correspondantes
        } else {
            statusMatch = (targetedStatus === '0' && status) || (targetedStatus === '1' && !status); // Inverser la comparaison
        }
        const dateMatch = (targetedDate === '') || (item.getAttribute('data-demande-date') === targetedDate);
        if (statusMatch && dateMatch) {
            item.classList.remove('d-none');
        } else {
            item.classList.add('d-none');
        }
    });
}
const demandeStatusSelect = document.getElementById('demandeStatusSelect');
demandeStatusSelect.addEventListener('change', applyDemandeContactFilter);

const demandeDateSelect = document.getElementById('demande-date-select');
demandeDateSelect.addEventListener('change', applyDemandeContactFilter);

applyDemandeContactFilter();