document.getElementById('user-create').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêche le formulaire de se soumettre normalement

    let formData = {
        email: document.getElementById('email').value,
        mdp: document.getElementById('mdp').value,
        remember: document.getElementById('remember').checked
    };

    fetch('../api/components/ForumUsersLogin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Traitement en cas de succès (redirection, affichage de message, etc.)
            window.location.href = 'index.php';
        } else {
            // Affichage d'un message d'erreur
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});