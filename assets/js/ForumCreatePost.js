document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement
        
        // Récupérer le contenu du champ "contenu"
        const contenu = document.getElementById('contenu').value;

        // Récupérer l'ID du sujet
        const sujetId = document.querySelector('input[name="sujet_id"]').value; 

        // Vous pouvez maintenant utiliser "contenu" et "sujetId" pour envoyer les données au serveur
        console.log('Contenu du post :', contenu);
        console.log('ID du sujet :', sujetId);

        // Envoi des données au serveur
        fetch('../api/components/ForumPostSujet.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ contenu: contenu, sujetId: sujetId })
        })
        .then(response => {
            // Vérifier le statut de la réponse
            if (!response.ok) {
                throw new Error('La requête a échoué : ' + response.status);
            }
            // Renvoyer la réponse sous forme de JSON
            return response.json();
        })
        .then(data => {
            // Traiter la réponse JSON du serveur
            console.log('Réponse du serveur :', data);
        })
        .catch(error => console.error('Erreur lors de l\'envoi des données au serveur :', error));
    });
});
