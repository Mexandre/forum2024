document.querySelectorAll('.sujet-link').forEach(element => {
    element.addEventListener('click', async (event) => {
      // Empêcher le comportement par défaut du lien
      event.preventDefault();
  
      // Extraire sujet_id de l'href de l'élément
      const href = element.getAttribute('href');
      const urlParams = new URL(href).searchParams;
      const sujetId = urlParams.get('sujet_id');
  
      // Si sujetId est trouvé, effectuer la requête fetch ou toute autre action nécessaire
      if (sujetId) {
        await fetchData(sujetId);
      }
    });
  });

async function fetchData(sujetId) {
    const url = `../api/components/ForumPost.php?sujet_id=${sujetId}`;
    try {
      const response = await fetch(url);
      const data = await response.json();
      // Traiter les données reçues
      // Par exemple, vous pouvez rediriger l'utilisateur vers forum_posts.php avec les données traitées
      if (data.success) {
        // Construction de l'URL de redirection avec les données traitées
        const redirectURL = `forum_posts.php?sujet_id=${sujetId}&data_traitée=${data.data_traitée}`;
        // Redirection vers forum_posts.php avec les données traitées
        window.location.href = redirectURL;
      } else {
        console.error('Erreur lors de la récupération des données:', data.msg);
      }
    } catch (error) {
      console.error('Erreur lors de la récupération des données:', error);
    }
}
