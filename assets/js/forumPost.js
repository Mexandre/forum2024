// Écouteur d'événements pour les liens de sujet
const sujetLinks = document.querySelectorAll('.sujet-link');
sujetLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        // Empêcher le comportement par défaut du lien
        event.preventDefault();
        
        // Récupérer l'ID du sujet à partir de l'attribut data-sujet-id
        const sujetId = link.dataset.sujetId;
        
        // Rediriger l'utilisateur vers la nouvelle page avec l'ID du sujet en tant que paramètre d'URL
        window.location.href = `ForumPosts.php?sujet_id=${sujetId}`;
    });
});