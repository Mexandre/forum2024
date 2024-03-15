document.addEventListener('DOMContentLoaded', async function() {
    try {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');  
        if (id) {
            // Étape 2: Envoyer une requête asynchrone pour récupérer les données de l'utilisateur
            const response = await fetch(`../api/components/ForumUsersData.php?id=${id}`);
            if (!response.ok) {
                throw new Error(`Erreur réseau avec le statut: ${response.status}`);
            }
            const data = await response.json();
            console.log(data)
            const userData = Array.isArray(data) ? data[0] : data;

            if(userData) {
                document.getElementById('username').value = userData.username || '';
                document.getElementById('email').value = userData.email || '';
                document.getElementById('lastname').value = userData.lastname || ''; 
                document.getElementById('firstname').value = userData.firstname || '';
                document.getElementById('address').value = userData.address || '';
                document.getElementById('zipcode').value = userData.zipcode || ''; 
                document.getElementById('city').value = userData.city || '';
                document.getElementById('country').value = userData.country || '';
                document.getElementById('email-blocked').checked = userData.email_blocked == '1';
                document.getElementById('blocked').checked = userData.blocked == '1';
            }
        }
    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
    }
});

document.getElementById('user-edit').addEventListener('submit', async function(e) {
    e.preventDefault(); // Empêche la soumission normale du formulaire

    // Récupérer les valeurs du formulaire
    const formData = {
        id: document.getElementById('id').value,
        username: document.getElementById('username').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        lastname: document.getElementById('lastname').value,
        firstname: document.getElementById('firstname').value,
        address: document.getElementById('address').value,
        zipcode: document.getElementById('zipcode').value,
        city: document.getElementById('city').value,
        country: document.getElementById('country').value,
        blocked: document.getElementById('blocked').checked,
        email_blocked: document.getElementById('email-blocked').checked
    };
    console.log(formData)
    try {
        const response = await fetch(`../api/components/ForumUsersData.php`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });
        if (!response.ok) {
            throw new Error(`Erreur réseau avec le statut: ${response.status}`);
        }
        try {
            const responseText = await response.text();
            console.log(responseText);
            // Masquer le formulaire
            document.getElementById('user-edit').style.display = 'none';

            // Afficher le message de succès
            const successMessage = document.createElement('h2');
            successMessage.textContent = "Profil mis à jour avec succès. Redirection...";
            document.body.appendChild(successMessage);

            // Redirection vers la page forum_user_form_find.php après 3 secondes
            setTimeout(function() {
                window.location.href = 'index.php?action=users';
            }, 2000);
        } catch (error) {
            console.error('Erreur lors de la récupération de la réponse en texte :', error);
        }
                
    //    alert('Profil mis à jour avec succès.');
    } catch (error) {
        console.error('Erreur lors de la mise à jour du profil:', error);
    }
});
document.getElementById('delete-user').addEventListener('click', async function(e) {
    e.preventDefault(); // Empêche la soumission normale du formulaire

    // Récupérer les valeurs du formulaire
    const formData = {
        id: document.getElementById('id').value
    };
    console.log(formData)
    try {
        const response = await fetch(`../api/components/ForumUsersData.php`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });
        if (!response.ok) {
            throw new Error(`Erreur réseau avec le statut: ${response.status}`);
        }
        try {
            const responseText = await response.text();
            console.log(responseText);
            // Masquer le formulaire
            document.getElementById('user-edit').style.display = 'none';

            // Afficher le message de succès
            const successMessage = document.createElement('h2');
            successMessage.textContent = "Profil supprimé. Redirection...";
            document.body.appendChild(successMessage);

            // Redirection vers la page forum_user_form_find.php après 3 secondes
            setTimeout(function() {
                window.location.href = 'index.php?action=users';
            }, 2000);
        } catch (error) {
            console.error('Erreur lors de la récupération de la réponse en texte :', error);
        }
                
    //    alert('Profil mis à jour avec succès.');
    } catch (error) {
        console.error('Erreur lors de la mise à jour du profil:', error);
    }
});
