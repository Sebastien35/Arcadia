const dateInput = document.getElementById('dateInput');
const repas = document.querySelectorAll('.repas');
const repasDate = document.querySelectorAll('.repasdate');

dateInput.addEventListener('change', function() {
    // Quelle option a été sélectionnée ?
    let selectedOption = parseInt(dateInput.value);
    // Quelle est la date d'aujourd'hui ?
    let today = new Date();
    // Quelle est le premier jour de la semaine ?
    let weekStart = new Date();
    weekStart.setDate(today.getDate() - today.getDay()); 
    // Quelle est le premier jour du mois ?
    let monthStart = new Date(today.getFullYear(), today.getMonth(), 1); 
    

    repas.forEach((repasItem, index) => {
        // Quelle est la date du repas ?
        let repasDateString = repasDate[index].textContent;
        // Séparer la date en jour, mois et année en séparant avec -
        let [day, month, year] = repasDateString.split('-'); 
        let repasDateTime = new Date(year, month - 1, day); 
    
        switch (selectedOption) {
            case 1: // Today
                if (isSameDay(repasDateTime, today)) {
                    repasItem.classList.remove('d-none');
                } else {
                    repasItem.classList.add('d-none');
                }
                break;
            case 2: // This week
                if (repasDateTime >= weekStart && repasDateTime <= today) {
                    repasItem.classList.remove('d-none');
                } else {
                    repasItem.classList.add('d-none');
                }
                break;
            case 3: // This month
                if (repasDateTime.getFullYear() === today.getFullYear() &&
                    repasDateTime.getMonth() === today.getMonth()) {
                    repasItem.classList.remove('d-none');
                } else {
                    repasItem.classList.add('d-none');
                }
                break;
            default: // All meals
                repasItem.classList.remove('d-none');
        }
    });
});

function isSameDay(date1, date2) {
    return date1.getFullYear() === date2.getFullYear() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getDate() === date2.getDate();
}

