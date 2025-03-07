document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('details-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalDescription = document.getElementById('modal-description');
    const modalDirector = document.getElementById('modal-director');
    const modalGenre = document.getElementById('modal-genre');
    const modalRelease = document.getElementById('modal-release');
    const modalDuration = document.getElementById('modal-duration');
    const closeModal = document.querySelector('.close-modal');

    document.querySelectorAll('.view-details-btn').forEach(button => {
        button.addEventListener('click', () => {
            const filmId = button.getAttribute('data-id');

            fetch(`get_film_details.php?id=${filmId}`)
                .then(response => response.json())
                .then(data => {
                    modalTitle.textContent = data.name;
                    modalDescription.textContent = `Description: ${data.description}`;
                    modalDirector.textContent = `Director: ${data.director}`;
                    modalGenre.textContent = `Genre: ${data.genre}`;
                    modalRelease.textContent = `Release Date: ${data.release_date}`;
                    modalDuration.textContent = `Duration: ${data.duration} minutes`;
                    modal.style.display = 'flex';
                })
                .catch(error => console.error('Error fetching film details:', error));
        });
    });

    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', event => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});