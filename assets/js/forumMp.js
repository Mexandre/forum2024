const mpForum = document.getElementById('mpForum');
const nouveauMessageBtn = document.getElementById('nouveauMessageBtn');
const fermerBtn = document.getElementById('fermerBtn');

nouveauMessageBtn.addEventListener('click', function () {
    mpForum.style.display = 'block';
});

fermerBtn.addEventListener('click', function () {
    mpForum.style.display = 'none';
});
// recherche autocomplete
const searchInput = document.getElementById('destinataire');
const searchResults = document.getElementById('search-destinataire'); 
let lastQuery = ''; 

searchInput.addEventListener('input', function () {
    const query = this.value.trim(); 

    if (query.length >= 3 && query !== lastQuery) {
        fetch(`../api/components/ForumUsersData.php?q=${query}`)
            .then(response => response.json())
            .then(data => {
                displayResults(data);
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données :', error);
            });

        lastQuery = query; 
    } else if (query.length < 3) {
        searchResults.innerHTML = '';
    }
});

function displayResults(data) {
    searchResults.innerHTML = '';

    if (data.length > 0) {
        const resultList = document.createElement('ul');

        data.forEach(result => {
            const listItem = document.createElement('li');
            const nameLink = document.createElement('a');
            nameLink.textContent = result.username;
            nameLink.addEventListener('click', function (event) {
                document.getElementById('destinataire').value = result.username;
                document.querySelector('input[name="userId"]').value = result.id; 
                searchResults.innerHTML = '';
                
                fetch(`../api/components/ForumUsersData.php?id=${result.id}`)
                    .then(response => response.json())
                    .then(userData => {
                        console.log('Détails de l\'utilisateur:', userData);
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des détails de l\'utilisateur:', error);
                    });
            });

            listItem.appendChild(nameLink);
            resultList.appendChild(listItem);
        });

        searchResults.appendChild(resultList);
    } else {
        searchResults.innerHTML = '<p>Aucun résultat trouvé.</p>';
    }
};

const form = document.querySelector("#mpForum");

form.addEventListener("submit", (e) => {
    e.preventDefault();

    let datasDuForm = new FormData(form);
    let objetJs = {};
    datasDuForm.forEach((value, key) => objetJs[key] = value);
    console.log(objetJs);
    let objectJson = JSON.stringify(objetJs);
    console.log(objectJson);

    fetch('../api/components/ForumMp.php', {
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
        document.querySelector("#mpForum").style.display = "none";
    })
    .catch(error => {
        console.error("Erreur lors de l'envoi des données:", error);
    });
});