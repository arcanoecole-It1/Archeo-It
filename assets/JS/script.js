let navLinks = document.querySelectorAll('.navLinks');
const activePage = window.location.pathname.split('/').pop(); // Récupère uniquement le nom du fichier

navLinks.forEach(link => {
    const linkPage = link.href.split('/').pop(); // Récupère uniquement le nom du fichier de chaque lien
    link.closest('.list').classList.remove('act');
    if (linkPage === activePage) {
        link.closest('.list').classList.add('act');
    }
});

function showLoginMessage() {
    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
}

function toggleDescription(index) {
    const descriptionElement = document.getElementById('desc-' + index);
    const buttonElement = document.getElementById('btn-' + index);

    if (descriptionElement.classList.contains('collapsed')) {
        // Passer de réduit à déplié
        descriptionElement.classList.remove('collapsed');
        descriptionElement.classList.add('expanded');
        buttonElement.textContent = 'Lire moins'; // Changer le texte du bouton
    } else {
        // Passer de déplié à réduit
        descriptionElement.classList.remove('expanded');
        descriptionElement.classList.add('collapsed');
        buttonElement.textContent = 'Lire plus'; 
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const descriptions = document.querySelectorAll('.description-text');
    descriptions.forEach((descElement, index) => {
        const buttonElement = document.getElementById('btn-' + index);
        const isInitiallyCollapsed = descElement.classList.contains('collapsed');
        if (buttonElement) {
            // On vérifie si la description est réellement plus longue que la hauteur collapsed
            const computedStyle = window.getComputedStyle(descElement);
            const maxHeight = parseFloat(computedStyle.maxHeight); 
            const scrollHeight = descElement.scrollHeight; // hauteur réelle du contenu
            if (scrollHeight <= maxHeight) {
                // Si le contenu tient dans la hauteur réduite on cacher le bouton "Lire plus"
                buttonElement.style.display = 'none';
            } else {
                // Sinon on s'assure que le bouton est visible
                buttonElement.style.display = 'block';
                if (isInitiallyCollapsed) {
                    descElement.classList.add('collapsed');
                    descElement.classList.remove('expanded');
                }
            }
        }
    });
});