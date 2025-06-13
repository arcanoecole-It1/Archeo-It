function copyPassword() {
    const passwordField = document.getElementById('generatedPassword');
    const passwordInput = document.getElementById('password');
    
    // Copier dans le presse-papier
    passwordField.select();
    document.execCommand('copy');
    
    // Remplir automatiquement le champ mot de passe
    passwordInput.value = passwordField.value;
    
    // Feedback visuel
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check"></i> Copié!';
    btn.classList.remove('btn-secondary');
    btn.classList.add('btn-success');
    
    setTimeout(() => {
        btn.innerHTML = originalHTML;
        btn.classList.remove('btn-success');
        btn.classList.add('btn-secondary');
    }, 2000);
}