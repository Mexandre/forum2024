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
    const url = `https://example.com/api/endpoint?param=${sujetId}`;
    try {
      const response = await fetch(url);
      const data = await response.json();
      // Traiter les données reçues, par exemple, afficher un message de succès
      console.log(data);
    } catch (error) {
      console.error('Erreur lors de la récupération des données:', error);
    }
  }
  
