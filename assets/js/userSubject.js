const form = document.querySelector("#createSubjectForm");

form.addEventListener("submit", (e) => {
    e.preventDefault(); // Empêche le rechargement de la page
    
    // Création d'un objet avec les données du formulaire
    const formData = new FormData(form);
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });
    
    // Envoi des données au serveur au format JSON
    fetch('../api/components/ForumUsersData.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(jsonData) // Conversion de l'objet JSON en chaine de caractère
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('La requête a échoué');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            console.log(data.msg);
            // Faire quelque chose en cas de succès, par exemple actualiser la page
            window.location.reload();
        } else {
            console.error(data.msg);
        }
    })
    .catch(error => {
        console.error("Erreur:", error);
    });
});
