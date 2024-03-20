// document.addEventListener('DOMContentLoaded', function() {
//     const containerForum = document.querySelector('#containerTheme');
//     containerForum.addEventListener('click', function() {
//         containerForum.style.display = 'none';
//         fetchThemeData();
//     });
// });

// function fetchThemeData() {
//     fetch('../api/components/ForumAdmin.php?type=themes')
//         .then(response => response.json())
//         .then(data => {
//             populateTableTheme(data);
//         })
//         .catch(error => {
//             console.error('Error fetching forum data:', error);
//         });
// }

// function populateTableTheme(data) {
//     const tbody = document.querySelector('#themeTable tbody');
//     tbody.innerHTML = '';
//     data.forEach(forum_theme => {
//         const row = document.createElement('tr');
//         const cell1 = document.createElement('td');
//         cell1.textContent = forum_theme.id;
//         row.appendChild(cell1);
//         const cell2 = document.createElement('td');
//         cell2.textContent = forum_theme.nom;
//         row.appendChild(cell2);
//         tbody.appendChild(row);
//     });
// }

// // AFFICHAGE DES SUJETS

// document.addEventListener('DOMContentLoaded', function() {
//     const containerForum = document.querySelector('#containerTopic');
//     containerForum.addEventListener('click', function() {
//         containerForum.style.display = 'none';
//         fetchTopicData();
//     });
// });

// function fetchTopicData() {
//     fetch('../api/components/ForumAdmin.php?type=topics')
//         .then(response => response.json())
//         .then(data => {
//             populateTableTopic(data);
//         })
//         .catch(error => {
//             console.error('Error fetching forum data:', error);
//         });
// }

// function populateTableTopic(data) {
//     const tbody = document.querySelector('#topicTable tbody');
//     tbody.innerHTML = '';
//     data.forEach(forum_topic => {
//         const row = document.createElement('tr');
//         const cell1 = document.createElement('td');
//         cell1.textContent = forum_topic.id;
//         row.appendChild(cell1);
//         const cell2 = document.createElement('td');
//         cell2.textContent = forum_topic.title;
//         row.appendChild(cell2);
//         tbody.appendChild(row);
//     });
// }

// // CREATION D'UN THEME

// const form = document.querySelector("#theme-create");

// form.addEventListener("submit", async (e) => {
//     e.preventDefault(); // Prevent page reload

//     // Get form data
//     const formData = new FormData(form);
//     console.log(formData)
//     const objectJson = JSON.stringify(Object.fromEntries(formData))
//     console.log(objectJson)

//     // Add action key to specify the operation
//     formData.append('action', 'create_theme'); // Append action to form data

//     try {
//         // Send data via POST request
//         const response = await fetch('../api/components/ForumAdmin.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json' 
//             },
//             body: objectJson
//         });
//             console.log(response)
//         // Check if request was successful
//         if (response.ok) {
//             // Get the response body as JSON
//             const responseData = await response.json();
//             if (responseData.success) {
//                 // If operation was successful, display message
//                 document.querySelector("#response").innerHTML = "Le thème a été créé avec succès";

//                 // Clear message after 3 seconds
//                 setTimeout(function() {
//                     document.querySelector("#response").innerHTML = "";
//                 }, 3000);
//             } else {
//                 // If operation failed, display error message
//                 console.error(responseData.msg);
//             }
//         } else {
//             console.error('Network response was not ok.');
//         }
//     } catch (error) {
//         console.error("An error occurred:", error);
//     }
// });