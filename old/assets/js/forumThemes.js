document.addEventListener('DOMContentLoaded', function() {
    fetch('../api/components/ForumTheme.php') // Remplacez par le chemin correct vers votre script PHP
        .then(response => response.json())
        .then(data => {
            const container = document.querySelector('.themes-container'); // Assurez-vous que cet élément existe dans votre HTML
            container.innerHTML = ''; // Vide le conteneur au cas où
            data.forEach(theme => {
                const link = document.createElement('a');
                link.href = `#${theme.id}`; // Utilisez l'id pour construire le lien
                link.textContent = theme.nom; // Nom du thème comme texte du lien
                container.appendChild(link);
            });
        })
        .catch(error => console.error('Erreur lors de la récupération des thèmes:', error));
});

