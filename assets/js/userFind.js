
// recherche autocomplete
const searchInput = document.getElementById('search-input')
const searchResults = document.getElementById('search-results')
let lastQuery = '' // Pour stocker la dernière requête

searchInput.addEventListener('input', function() {
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
            nameLink.href = '#'; // Définissez ici l'URL souhaitée ou utilisez un attribut de données pour stocker l'ID
            nameLink.textContent = result.pseudo; // Supposons que le résultat ait une propriété 'pseudo'
            // Écouteur d'événements pour afficher le formulaire de modification lors du clic sur le nom
            nameLink.addEventListener('click', function(event) {
                event.preventDefault(); // Empêche le comportement de lien par défaut
                // Affiche le formulaire de modification avec les données du résultat
                displayUpdateForm(result);
                // Masque l'ID de l'utilisateur
                document.getElementById('user-create').style.display = 'none';
            });

            // Ajoute le lien du nom à l'élément de liste
            listItem.appendChild(nameLink);

            // Ajoute l'adresse e-mail à l'élément de liste
            const emailSpan = document.createElement('span');
            emailSpan.textContent = result.email; // Supposons que le résultat ait une propriété 'email'
            listItem.appendChild(emailSpan);

            // Ajoute l'élément de liste à la liste non ordonnée
            resultList.appendChild(listItem);
        });

        // Ajoute la liste de résultats à l'élément de résultats de recherche
        searchResults.appendChild(resultList);
    } else {
        // Si aucune donnée n'est renvoyée, affiche un message indiquant qu'aucun résultat n'a été trouvé
        searchResults.innerHTML = '<p>Aucun résultat trouvé.</p>';
    }
}

function displayUpdateForm(result) {
    // Crée un formulaire
    const form = document.createElement('form');
    
    // Ajoute un titre h2 pour le formulaire
    const title = document.createElement('h2');
    title.textContent = 'Modifier l\'utilisateur';
    form.appendChild(title);

    // Ajoute un label et un champ pour le pseudo
    const pseudoLabel = document.createElement('label');
    pseudoLabel.textContent = 'Pseudo:';
    form.appendChild(pseudoLabel);

    const pseudoInput = document.createElement('input');
    pseudoInput.type = 'text';
    pseudoInput.name = 'pseudo';
    pseudoInput.value = result.pseudo;
    form.appendChild(pseudoInput);

    // Ajoute un label et un champ pour l'email
    const emailLabel = document.createElement('label');
    emailLabel.textContent = 'Email:';
    form.appendChild(emailLabel);

    const mailInput = document.createElement('input');
    mailInput.type = 'mail';
    mailInput.name = 'mail';
    mailInput.value = result.mail;
    form.appendChild(mailInput);

    // Ajoute un label et un champ pour le mot de passe
    const passwordLabel = document.createElement('label');
    passwordLabel.textContent = 'Mot de passe:';
    form.appendChild(passwordLabel);

    const passwordInput = document.createElement('input');
    passwordInput.type = 'password';
    passwordInput.name = 'mdp';
    form.appendChild(passwordInput);

    // Ajoute un champ caché pour l'ID
    const idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'id';
    idInput.value = result.id;
    form.appendChild(idInput);

    // Ajoute un bouton de soumission pour mettre à jour
    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.textContent = 'Mettre à jour';
    form.appendChild(submitButton);

    // Ajoute un bouton de suppression pour supprimer l'entrée
    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.id = 'delete';
    deleteButton.textContent = 'Supprimer';
    form.appendChild(deleteButton);

    // Gère la suppression de l'utilisateur
    deleteButton.addEventListener('click', function() {
        if (confirm("Voulez-vous vraiment supprimer cet utilisateur ?")) {
            const userId = result.id;
            fetch(`../api/components/ForumUsersData.php?id=${userId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                console.log('Utilisateur supprimé avec succès:', data);
                // Vous pouvez ajouter ici un message de confirmation ou une redirection vers une autre page
            })
            .catch(error => {
                console.error('Erreur lors de la suppression de l\'utilisateur:', error);
                // Gérer les erreurs, par exemple afficher un message à l'utilisateur
            });
            form.style.display = 'none';
        }
    });

    // Gère la soumission du formulaire
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        updateData(new FormData(form));
        form.style.display = 'none';
    });

    // Affiche le formulaire dans la section #user
    const userSection = document.getElementById('user');
    userSection.innerHTML = '';
    userSection.appendChild(form);
}
function updateData(formData) {
    const jsonData = JSON.stringify(Object.fromEntries(formData.entries()));
    // Effectue une requête PATCH pour mettre à jour les données dans la base de données
    fetch('../api/components/ForumUsersData.php', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json'
        },
        body: jsonData // Envoyez les données JSON
    })
    .then(response => response.json())
    .then(data => {
        // Affiche un message de réussite ou gère les erreurs
        console.log('Données mises à jour avec succès:', data);
        document.getElementById("user").innerHTML = 'Données mises à jour avec succès'
        // Vous pouvez ajouter ici un message de confirmation ou une redirection vers une autre page
    })
    .catch(error => {
        console.error('Erreur lors de la mise à jour des données:', error);
        // Gérer les erreurs, par exemple afficher un message à l'utilisateur
    });
}
