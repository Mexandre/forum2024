const form = document.querySelector("#createSubjectForm")
document.addEventListener('DOMContentLoaded', function() {
    const formContainer = document.createElement('div'); // Créez un conteneur pour le formulaire
    formContainer.id = 'createSubjectFormContainer'; // Donnez un ID au conteneur
    formContainer.style.display = 'none'; // Cachez le conteneur par défaut

    // Créez le formulaire de création de sujet
    const createSubjectForm = document.createElement('form');
    createSubjectForm.id = 'createSubjectForm';
    createSubjectForm.innerHTML = `
        <input type="hidden" id="id_theme" name="id_theme">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre">
        <input type="submit" value="Créer le sujet">
    `;

    formContainer.appendChild(createSubjectForm); // Ajoutez le formulaire au conteneur

    // Ajoutez le conteneur du formulaire à la page
    document.body.appendChild(formContainer);

    // Écouteur d'événement pour les clics sur les thèmes
    const container = document.querySelector('.themes-container');
    container.addEventListener('click', function(event) {
        if (event.target.tagName === 'A') {
            // Affichez le formulaire de création de sujet lorsque vous cliquez sur un thème
            formContainer.style.display = 'block';
        }
    });

    // Ajoutez un écouteur d'événements pour le formulaire de création de sujet
    createSubjectForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page

        // Récupérez les données du formulaire et envoyez-les au serveur
        // Vous devrez implémenter cette partie pour gérer l'envoi des données au serveur
        const formData = new FormData(createSubjectForm);
        const titre = formData.get('titre');

        // Affichez un message de succès ou d'erreur après l'envoi des données au serveur
        console.log('Titre du sujet :', titre);
    });
});