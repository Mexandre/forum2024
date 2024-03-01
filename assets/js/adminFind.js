// Ce fichier JS gère une fonctionnalité de recherche avec autocomplete

// Sélectionne l'élément input pour la recherche
const searchInput = document.getElementById('search-input');

// Sélectionne l'élément où seront affichés les résultats de la recherche
const searchResults = document.getElementById('search-results');

// Initialise une variable pour stocker la dernière requête effectuée
let lastQuery = '';

// Écouteur d'événements qui se déclenche lors de la saisie dans l'input de recherche
searchInput.addEventListener('input', function() {
    // Récupère la valeur saisie dans l'input et supprime les espaces blancs au début et à la fin
    const query = this.value.trim();

    // Vérifie si la longueur de la requête est suffisante (au moins 3 caractères) et si elle est différente de la dernière requête
    if (query.length >= 3 && query !== lastQuery) {
        // Effectue une requête pour récupérer les données en fonction de la requête de recherche
        fetch(`../api/components/ForumUsersData.php?q=${query}`)
            .then(response => response.json())
            .then(data => {
                // Affiche les résultats de la recherche
                displayResults(data);
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données:', error);
            });

        lastQuery = query; // Met à jour la dernière requête
    } else if (query.length < 3) {
        // Efface les résultats si la longueur de la requête est inférieure à 3 caractères
        searchResults.innerHTML = '';
    }
});

// Fonction pour afficher les résultats de la recherche
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
            nameLink.href = '#'; // Lien vide pour l'instant
            nameLink.textContent = result.pseudo; // Affiche le pseudo du résultat
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
            emailSpan.textContent = result.email; // Affiche l'email du résultat
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

// Fonction pour afficher le formulaire de modification des données utilisateur
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
    pseudoInput.value = result.pseudo; // Préremplit le champ avec le pseudo du résultat
    form.appendChild(pseudoInput);

    // Ajoute un label et un champ pour l'email
    const emailLabel = document.createElement('label');
    emailLabel.textContent = 'Email:';
    form.appendChild(emailLabel);

    const mailInput = document.createElement('input');
    mailInput.type = 'email';
    mailInput.name = 'mail';
    mailInput.value = result.mail; // Préremplit le champ avec l'email du résultat
    form.appendChild(mailInput);

    // Ajoute un label et un champ pour le mot de passe
    const passwordLabel = document.createElement('label');
    passwordLabel.textContent = 'Mot de passe:';
    form.appendChild(passwordLabel);

    const passwordInput = document.createElement('input');
    passwordInput.type = 'password';
    passwordInput.name = 'mdp';
    form.appendChild(passwordInput);

    // Crée l'étiquette pour le champ de sélection de rang
    const rangLabel = document.createElement('label');
    rangLabel.textContent = 'Modifier le rang:';

    // Crée la liste déroulante pour le rang
    const rangInput = document.createElement('select');
    rangInput.name = 'rang';

    // Ajoute des styles CSS à la liste déroulante
    rangInput.style.padding = '10px';
    rangInput.style.border = '1px solid #ccc';
    rangInput.style.borderRadius = '4px';
    rangInput.style.fontSize = '16px';
    rangInput.style.width = '100%';
    rangInput.style.backgroundColor = '#fff';

    // Ajoute des événements pour le focus et le blur de la liste déroulante
    rangInput.addEventListener('focus', function() {
        this.style.outline = 'none'; // Supprime la bordure lorsqu'il est en focus
    });

    rangInput.addEventListener('blur', function() {
        this.style.borderColor = '#ccc'; // Rétablit la couleur de la bordure lorsqu'il perd le focus
        this.style.boxShadow = 'none'; // Supprime l'ombre lorsqu'il perd le focus
    });

    // Effectue une requête pour récupérer les niveaux depuis la base de données et les ajoute à la liste déroulante
    fetch('../api/components/ForumUsersData.php?getLevels=true')
        .then(response => response.json())
        .then(data => {
            // Ajoute les options pour chaque niveau
            data.forEach(level => {
                const option = document.createElement('option');
                option.value = level.id;
                option.textContent = level.niveau;
                rangInput.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des niveaux:', error);
        });

    // Ajoute l'étiquette et le champ de sélection de rang au formulaire
    form.appendChild(rangLabel);
    form.appendChild(rangInput);

    // Ajoute un champ caché pour l'ID de l'utilisateur
    const idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'id';
    idInput.value = result.id; // Récupère l'ID du résultat et l'assigne au champ caché
    form.appendChild(idInput);

    // Ajoute un bouton pour avertir l'utilisateur
    const avertirButton = document.createElement('button');
    avertirButton.type = 'submit';
    avertirButton.id = 'Avertir';
    avertirButton.textContent = 'Avertir';
    form.appendChild(avertirButton);

    // Ajoute un bouton pour bloquer l'utilisateur
    const bloqueButton = document.createElement('button');
    bloqueButton.type = 'submit';
    bloqueButton.id = 'Bloque';
    bloqueButton.textContent = 'Bloquer';
    form.appendChild(bloqueButton);
    
    // Ajoute un champ caché pour l'avertissement
    const avertissementInput = document.createElement('input');
    avertissementInput.type = 'hidden';
    avertissementInput.name = 'avertissement';
    avertissementInput.value = result.avertissement; // Récupère l'avertissement du résultat et l'assigne au champ caché
    form.appendChild(avertissementInput);

    // Ajoute un bouton de suppression pour supprimer l'entrée utilisateur
    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.id = 'delete';
    deleteButton.textContent = 'Supprimer';
    form.appendChild(deleteButton);

    // Ajoute un bouton de soumission pour mettre à jour les données utilisateur
    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.textContent = 'Mettre à jour';
    form.appendChild(submitButton);

    // Gère la suppression de l'utilisateur lors du clic sur le bouton de suppression
    deleteButton.addEventListener('click', function() {
        if (confirm("Voulez-vous vraiment supprimer cet utilisateur ?")) {
            const userId = result.id; // Récupère l'ID de l'utilisateur
            // Effectue une requête DELETE pour supprimer l'utilisateur de la base de données
            fetch(`../api/components/ForumUsersData.php?id=${userId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                console.log('Utilisateur supprimé avec succès:', data);
                // Affiche un message de confirmation ou gère les erreurs
            })
            .catch(error => {
                console.error('Erreur lors de la suppression de l\'utilisateur:', error);
                // Gère les erreurs, par exemple affiche un message à l'utilisateur
            });
            form.style.display = 'none'; // Masque le formulaire après la suppression
        }
    });

    // Gère la soumission du formulaire
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du formulaire
        updateData(new FormData(form)); // Appelle la fonction pour mettre à jour les données utilisateur
        form.style.display = 'none'; // Masque le formulaire après la soumission
    });

    // Affiche le formulaire dans la section #user
    const userSection = document.getElementById('user');
    userSection.innerHTML = ''; // Efface le contenu précédent
    userSection.appendChild(form); // Ajoute le formulaire à la section #user
}

// Fonction pour mettre à jour les données utilisateur
function updateData(formData) {
    const jsonData = JSON.stringify(Object.fromEntries(formData.entries()));
    // Effectue une requête PATCH pour mettre à jour les données dans la base de données
    fetch('../api/components/ForumUsersData.php', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json'
        },
        body: jsonData // Envoie les données JSON
    })
    .then(response => response.json())
    .then(data => {
        // Affiche un message de réussite ou gère les erreurs
        console.log('Données mises à jour avec succès:', data);
        document.getElementById("user").innerHTML = 'Données mises à jour avec succès';
        // Vous pouvez ajouter ici un message de confirmation ou une redirection vers une autre page
    })
    .catch(error => {
        console.error('Erreur lors de la mise à jour des données:', error);
        // Gère les erreurs, par exemple affiche un message à l'utilisateur
    });
}
