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