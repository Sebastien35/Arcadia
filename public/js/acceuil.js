let starRating = document.querySelector('.starRating');
let stars = document.querySelectorAll('.star');

starRating.addEventListener('input', function() {
    let rating = parseInt(this.value);
    console.log(rating);
    updateStarColors(rating);
});


function updateStarColors(rating) {
    stars.forEach(star => {
        let starValue = parseInt(star.dataset.value);
        if (starValue <= rating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}