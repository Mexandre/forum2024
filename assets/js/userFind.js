const searchInput = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');
//let lastQuery = ''; // Pour stocker la dernière requête

searchInput.addEventListener('input', async function() {
    const query = this.value.trim(); // Supprimer les espaces blancs en début et fin de chaîne

    if (query.length >= 3) {
        try {
            const response = await fetch(`../api/components/ForumUsersData.php?q=${query}`);
            const data = await response.json();
            // Afficher les résultats
            displayResults(data);
        } 
        catch (error) {
            console.error('Erreur lors de la récupération des données:', error);
        }

        lastQuery = query; // Mettre à jour la dernière requête
    } else if (query.length < 3) {
        // Effacer les résultats si la longueur de la requête est inférieure à 3
        searchResults.innerHTML = '';
    }
});

function displayResults(data) {
    // Efface les résultats précédents
    searchResults.innerHTML = '';

    if (data.length > 0) {
        const resultList = document.createElement('ul');

        data.forEach(result => {
            const listItem = document.createElement('li');
            const nameLink = document.createElement('a');
            nameLink.href = `index.php?action=users&type=admin&id=${result.id}`;
            nameLink.textContent = result.username;

            // Utilisation directe de l'attribut href pour la redirection au lieu d'un écouteur
            nameLink.addEventListener('click', function(event) {
                event.preventDefault(); // Empêche le comportement par défaut du lien
                window.location.href = this.href; // Redirige vers l'URL spécifiée
            });

            listItem.appendChild(nameLink);
            resultList.appendChild(listItem);
        });

        searchResults.appendChild(resultList);
    } else {
        searchResults.innerHTML = '<p>Aucun résultat trouvé.</p>';
    }
}
