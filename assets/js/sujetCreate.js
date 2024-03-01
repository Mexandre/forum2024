const form = document.querySelector("#createSubjectForm")

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
    
    fetch('../includes/forum_themes.php', {
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
        document.querySelector("#createSubjectForm").style.display = "none"
        document.querySelector("#msg").innerHTML = "Enregistré"
    })
    .catch(error => {
        console.log(error)
        console.error("Y a un truc qui déconne", error)
    })
})