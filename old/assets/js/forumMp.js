// recherche autocomplete
const searchInput = document.getElementById('destinataire')
const searchResults = document.getElementById('search-destinataire') // Modification ici
let lastQuery = '' // Pour stocker la dernière requête

searchInput.addEventListener('input', function () {
    const query = this.value.trim(); // Supprimer les espaces blancs en début et fin de chaîne

    // Vérifier si la requête a une longueur suffisante et est différente de la dernière requête
    if (query.length >= 3 && query !== lastQuery) {
        // Effectuer la requête
        fetch(`../api/components/ForumUsersData.php?q=${query}`)
            .then(response => response.json())
            .then(data => {
                // Afficher les résultats
                displayResults(data)
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données:', error)
            })

        lastQuery = query // Mettre à jour la dernière requête
    } else if (query.length < 3) {
        // Effacer les résultats si la longueur de la requête est inférieure à 3
        searchResults.innerHTML = ''
    }
})
function displayResults(data) {
    // Efface les résultats précédents
    searchResults.innerHTML = '';

    // Vérifie si des données ont été renvoyées
    if (data.length > 0) {
        // Crée une liste non ordonnée pour afficher les résultats
        const resultList = document.createElement('ul');

        // Parcourt les données et crée un élément de liste pour chaque résultat
        data.forEach(result => {
            // Crée un élément de liste
            const listItem = document.createElement('li');

            // Crée un lien pour le nom du résultat
            const nameLink = document.createElement('a');
            nameLink.textContent = result.username;
            // Écouteur d'événements pour ajouter le nom au champ destinataire lors du clic
            nameLink.addEventListener('click', function (event) {
                // Ajouter le nom de l'utilisateur au champ destinataire
                document.getElementById('destinataire').value = result.username;
                // Cacher les résultats de recherche
                searchResults.innerHTML = '';
            });

            // Ajoute le lien du nom à l'élément de liste
            listItem.appendChild(nameLink);

            // Ajoute l'élément de liste à la liste non ordonnée
            resultList.appendChild(listItem);
        });

        // Ajoute la liste de résultats à l'élément de résultats de recherche
        searchResults.appendChild(resultList);
    } else {
        // Si aucune donnée n'est renvoyée, affiche un message indiquant qu'aucun résultat n'a été trouvé
        searchResults.innerHTML = '<p>Aucun résultat trouvé.</p>';
    }
    console.log(data)
}

const mpForum = document.getElementById('mpForum');
const nouveauMessageBtn = document.getElementById('nouveauMessageBtn');
const fermerBtn = document.getElementById('fermerBtn');

nouveauMessageBtn.addEventListener('click', function () {
    mpForum.style.display = 'block';
});

fermerBtn.addEventListener('click', function () {
    mpForum.style.display = 'none';
});

const form = document.querySelector("#mpForum");

form.addEventListener("submit", (e) => {
    e.preventDefault() // Empêche le rechargement de la page
    // On récupère les données du formulaire
    let datasDuForm = new FormData(form)
    // On crée un objet
    let objetJs = {}
    // On extrait les données du formData pour les mettre dans l'objet
    datasDuForm.forEach((value, key) => objetJs[key] = value)
    console.log(objetJs)
    let objectJson = JSON.stringify(objetJs)
    console.log(objectJson)
    // On contrôle le Json

    fetch('../api/components/ForumMp.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: objectJson
    })
        .then(response => {
            console.log(response)
        })
        .then(data => {
            document.querySelector("#mpForum").style.display = "none"
        })
        .catch(error => {
            console.log(error)
            console.error("Y a un truc qui déconne", error)
        })
})