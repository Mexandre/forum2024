document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.themes-container');
    const sujetsContainer = document.querySelector('.sujets-container');
    const titreH1 = document.querySelector('h1');
    const backButton = document.createElement('button');
    backButton.textContent = 'Retour aux thèmes';

    // Fonction pour charger les sujets en fonction de l'ID du thème
    function chargerSujets(themeId, themeNom) {
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
                        sujetElement.textContent = `${sujet.titre} - ${sujet.nb_posts} posts`;
                        sujetsContainer.appendChild(sujetElement);
                    });
                } else {
                    sujetsContainer.innerHTML = '<p>Aucun sujet trouvé pour ce thème.</p>';
                }
                // Masquer le conteneur des thèmes lors de l'affichage des sujets
                container.style.display = 'none';
                
                // Stocke l'ID du thème sélectionné
                sessionStorage.setItem('selectedThemeId', themeId);
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
        })
    });
