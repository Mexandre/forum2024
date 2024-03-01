const form = document.querySelector("#profil-create")

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
    
    fetch('../api/components/ForumProfilData.php', {
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
        document.querySelector("#profil-create").style.display = "none"
        document.querySelector("#msg").innerHTML = "Profil rempli avec succes"
    })
    .catch(error => {
        console.log(error)
        console.error("Y a un truc qui déconne", error)
    })
})