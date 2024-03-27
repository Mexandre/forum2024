document.addEventListener('DOMContentLoaded', function() {
    // Vérifiez si le formulaire de création de sujet est présent sur la page
    const form = document.querySelector("#createSubjectForm");
    if (!form) {
        // Si le formulaire n'est pas présent, arrêtez l'exécution du script
        return;
    }

    form.addEventListener("submit", (e) => {
        e.preventDefault(); // Empêche le rechargement de la page
        // On récupère les données du formulaire
        let datasDuForm = new FormData(form);
        // On crée un objet
        let objetJs = {};
        // On extrait les données du formData pour les mettre dans l'objet
        datasDuForm.forEach((value, key) => objetJs[key] = value);
        console.log(objetJs); // Affichez les données à envoyer dans la console
        let objectJson = JSON.stringify(objetJs);
        console.log(objectJson); // Affichez le JSON à envoyer dans la console
        // On contrôle le JSON
        
        // Vérifiez si les clés id_theme et titre sont présentes dans les données
        if (!objetJs.hasOwnProperty('id_theme') || !objetJs.hasOwnProperty('titre')) {
            console.error('Les clés id_theme et/ou titre ne sont pas présentes dans les données.');
            return; // Arrêtez l'exécution du script si les clés nécessaires sont absentes
        }

        fetch('../api/components/ForumThemes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' 
            },
            body: objectJson
        })
        .then(response => {
            console.log(response);
        })
        .then(data => {
            console.log(data); // Affichez la réponse du serveur dans la console
            document.querySelector("#createSubjectForm").style.display = "none";
            document.querySelector("#msg").innerHTML = "Enregistré";
        })
        .catch(error => {
            console.log(error);
            console.error("Y a un truc qui déconne", error);
        });
    });
});
    