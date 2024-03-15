document.addEventListener('DOMContentLoaded', function() {
    let selectedThemeId = ''; // Variable pour stocker l'ID du thème sélectionné

    const container = document.querySelector('.themes-container');
    const sujetsContainer = document.querySelector('.sujets-container');
    const titreH1 = document.querySelector('h1');
    const backButton = document.createElement('button');
    backButton.textContent = 'Retour aux thèmes';
    
    // Fonction pour charger les sujets en fonction de l'ID du thème
    function chargerSujets(themeId, themeNom) {
        console.log('ID du thème sélectionné :', themeId);
        console.log('ID du thème sélectionné :', selectedThemeId); // Vérifier la valeur de selectedThemeId

        selectedThemeId = themeId; // Stocke l'ID du thème sélectionné
        // Mettre à jour la valeur de l'input hidden
        const inputThemeId = document.querySelector('#id_theme');
        inputThemeId.value = selectedThemeId;
        fetch(`../api/components/ForumSujet.php?theme_id=${themeId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Réponse du serveur: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                sujetsContainer.innerHTML = ''; // Vide le conteneur au cas où

                if (data.length > 0) {
                    data.forEach(sujet => {
                        const sujetElement = document.createElement('a');
                        sujetElement.href = '#';
                        sujetElement.textContent = `${sujet.title} - ${sujet.num_replies} posts`;
                        // Ajoutez la classe "sujet-link" au lien
                        sujetElement.classList.add('sujet-link');
                        sujetElement.dataset.sujetId = sujet.id; // Ajouter l'ID du sujet comme attribut
                        sujetsContainer.appendChild(sujetElement);
                    });
                } else {
                    sujetsContainer.innerHTML = '<p>Aucun sujet trouvé pour ce thème.</p>';
                }
                // Masquer le conteneur des thèmes lors de l'affichage des sujets
                container.style.display = 'none';

                // Ajouter les écouteurs d'événements pour les liens de sujet
                const sujetLinks = document.querySelectorAll('.sujet-link');
                sujetLinks.forEach(link => {
                    link.addEventListener('click', function(event) {
                        // Empêcher le comportement par défaut du lien
                        event.preventDefault();
                        
                        // Récupérer l'ID du sujet à partir de l'attribut data-sujet-id
                        const sujetId = link.dataset.sujetId;
                        
                        // Rediriger l'utilisateur vers la nouvelle page avec l'ID du sujet en tant que paramètre d'URL
                        window.location.href = `../includes/forum_posts.php?sujet_id=${sujetId}`;
                    });
                });
            })
            .catch(error => console.error('Erreur lors de la récupération des sujets:', error));
    
        // Afficher le bouton de retour arrière et écouter l'événement
        backButton.addEventListener('click', function() {
            // Rediriger l'utilisateur vers la page index.php?action=topics
            window.location.href = 'index.php?action=topics';
        });
        titreH1.insertAdjacentElement('afterend', backButton); // Insérer le bouton après le titre
    }

    // Écouteur d'événement pour les liens de thème
    container.addEventListener('click', function(event) {
        if (event.target.tagName === 'A') {
            // Récupère l'ID et le nom du thème à partir du lien
            const themeId = event.target.href.split('#')[1];
            const themeNom = event.target.textContent.trim();

            // Met à jour le titre avec le nom du thème cliqué
            titreH1.textContent = `Sujets du thème ${themeNom}`;

            // Affiche le bouton de retour arrière
            backButton.style.display = 'block';

            // Charge les sujets associés au thème
            chargerSujets(themeId, themeNom);
        }
    });

    // Récupération des thèmes
    fetch('../api/components/ForumTheme.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Réponse du serveur: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            container.innerHTML = ''; // Vide le conteneur au cas où
            data.forEach(theme => {
                const link = document.createElement('a');
                link.href = `#${theme.id}`; // Utilisez l'id pour construire le lien
                link.textContent = theme.nom; // Nom du thème comme texte du lien
                container.appendChild(link);
            });
        });

    const formContainer = document.createElement('div'); // Créez un conteneur pour le formulaire
    formContainer.id = 'createSubjectFormContainer'; // Donnez un ID au conteneur
    formContainer.style.display = 'none'; // Cachez le conteneur par défaut

    // Créez le formulaire de création de sujet
    const createSubjectForm = document.createElement('form');
    createSubjectForm.id = 'createSubjectForm';
    createSubjectForm.innerHTML = `
        <label for="titre">Titre</label>
        <input type="hidden" id="id_theme" name="id_theme" value="${selectedThemeId}">
        <input type="text" id="titre" name="titre">
        <input type="submit" value="Créer le sujet">
    `;

    formContainer.appendChild(createSubjectForm); // Ajoutez le formulaire au conteneur

    // Ajoutez le conteneur du formulaire à la page
    document.body.appendChild(formContainer);

    createSubjectForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page

        // Récupérez les données du formulaire et envoyez-les au serveur
        // Vous devrez implémenter cette partie pour gérer l'envoi des données au serveur
        const formData = new FormData(createSubjectForm);
        const titre = formData.get('titre');
        const id_theme = selectedThemeId; // Utilisez l'ID du thème sélectionné

        // Affichez un message de succès ou d'erreur après l'envoi des données au serveur
        console.log('Titre du sujet :', titre);
        console.log('ID du thème :', id_theme);
        // Vous pouvez maintenant utiliser "titre" et "id_theme" pour envoyer les données au serveur
    });
});
