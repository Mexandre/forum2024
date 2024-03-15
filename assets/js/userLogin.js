document.getElementById('user-create').addEventListener('submit', async function(e) {
    e.preventDefault(); // Empêche le formulaire de se soumettre normalement

    let formData = {
        email: document.getElementById('email').value,
        mdp: document.getElementById('mdp').value,
        remember: document.getElementById('remember').checked
    };

    // Affiche les données du formulaire dans la console avant l'envoi
    console.log('FormData:', formData);

    try {
        const response = await fetch('../api/components/ForumUsersLogin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        console.log('Response received');
        
        const data = await response.json(); // Convertit la réponse en JSON
        
        console.log('Data:', data); // Affiche les données reçues

        if (data.success) {
            // Traitement en cas de succès (redirection, affichage de message, etc.)
            window.location.href = 'index.php';
        } else {
            // Affichage d'un message d'erreur
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }

    // Point d'arrêt pour déboguer avec les outils de développement (si nécessaire)
    // debugger;
});