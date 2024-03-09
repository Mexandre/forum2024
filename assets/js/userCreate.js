const form = document.querySelector("#user-create");

form.addEventListener("submit", async (e) => {
    e.preventDefault(); // Empêche le rechargement de la page

    // On récupère les données du formulaire
    const datasDuForm = new FormData(form);

    // On crée un objet
    let objetJs = {};

    // On extrait les données du formData pour les mettre dans l'objet
    datasDuForm.forEach((value, key) => {
        objetJs[key] = value;
    });

    const objectJson = JSON.stringify(objetJs);

    try {
        // On envoie les données en POST et on attend la réponse
        const response = await fetch('../api/components/ForumUsersData.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' 
            },
            body: objectJson
        });

       // Actions à réaliser après la réponse
        document.querySelector("#user-create").style.display = "none";
        document.querySelector("#msg").innerHTML = "Enregistré";

    } catch (error) {
        console.error("Y a un truc qui déconne", error);
    }
});
