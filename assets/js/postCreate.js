document.addEventListener('DOMContentLoaded', function() {
    // Récupérer l'ID du sujet à partir de l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const sujetId = urlParams.get('sujet_id');
    
    // Charger les posts liés à ce sujet en utilisant l'ID du sujet
    chargerPosts(sujetId);
});

function chargerPosts(sujetId) {
    // Effectuer une requête AJAX pour charger les posts liés à ce sujet
    fetch(`../api/components/ForumPosts.php?sujet_id=${sujetId}`)
        .then(response => response.json())
        .then(posts => {
            // Afficher les posts sur la page
            afficherPosts(posts);
        })
        .catch(error => console.error('Erreur lors de la récupération des posts:', error));
}

function afficherPosts(posts) {
    // Afficher les posts sur la page (par exemple, les ajouter à un élément HTML approprié)
    const postsContainer = document.getElementById('posts-container');
    postsContainer.innerHTML = ''; // Vider le conteneur au cas où
    
    posts.forEach(post => {
        const postElement = document.createElement('div');
        postElement.textContent = post.contenu;
        postsContainer.appendChild(postElement);
    });
}
