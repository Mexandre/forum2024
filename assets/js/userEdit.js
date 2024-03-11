document.addEventListener('DOMContentLoaded', async function() {
    try {
        // Étape 1: Extraire l'ID de l'URL
        const params = new URLSearchParams(window.location.search);
        const id = params.get('id');

        if (id) {
            // Étape 2: Envoyer une requête asynchrone pour récupérer les données de l'utilisateur
            const response = await fetch(`../api/components/ForumUsersData.php?id=${id}`);
            if (!response.ok) {
                throw new Error(`Erreur réseau avec le statut: ${response.status}`);
            }
            const data = await response.json();
            const userData = Array.isArray(data) ? data[0] : data;

            if(userData) {
                document.getElementById('username').value = userData.username || '';
                document.getElementById('email').value = userData.email || '';
                document.getElementById('lastname').value = userData.lastname || ''; // Si lastname est null dans votre objet
                document.getElementById('firstname').value = userData.firstname || '';
                document.getElementById('address').value = userData.address || '';
                document.getElementById('zipcode').value = userData.zipcode || ''; // Assurez-vous d'utiliser postal_code si zip n'est pas le bon nom de champ
                document.getElementById('city').value = userData.city || '';
                document.getElementById('country').value = userData.country || '';
                // Pas de champ pour birth_date, gender_id, last_update_date, level_id, warnings dans votre formulaire HTML
            }
              // Traiter les données de l'utilisateur ici
            // Afficher le nom de l'utilisateur dans un élément HTML
            //document.getElementById('nomUtilisateur').textContent = data.nom;
        }
    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
    }
});
document.getElementById('user-edit').addEventListener('submit', async function(e) {
    e.preventDefault(); // Empêche la soumission normale du formulaire

    // Récupérer les valeurs du formulaire
    const formData = {
        id,
        username: document.getElementById('username').value,
        email: document.getElementById('email').value,
        lastname: document.getElementById('lastname').value,
        firstname: document.getElementById('firstname').value,
        address: document.getElementById('address').value,
        zipcode: document.getElementById('zipcode').value,
        city: document.getElementById('city').value,
        country: document.getElementById('country').value
    };

    try {
        // Envoyer une requête PUT ou PATCH pour mettre à jour les données de l'utilisateur
        const response = await fetch(`../api/components/ForumUsersData.php`, {
            method: 'PATCH', // ou 'PATCH' selon vos besoins
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });
        if (!response.ok) {
            throw new Error(`Erreur réseau avec le statut: ${response.status}`);
        }
        const responseData = await response.json();
        console.log(responseData);
        
    //    alert('Profil mis à jour avec succès.');
    } catch (error) {
        console.error('Erreur lors de la mise à jour du profil:', error);
    }
});
