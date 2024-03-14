document.getElementById('drop-zone').addEventListener('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();

    let files = e.dataTransfer.files;
    uploadFiles(files);
    displayFileNames(files);
});

document.getElementById('drop-zone').addEventListener('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
});

function uploadFiles(files) {
    let formData = new FormData();

    for (let i = 0; i < files.length; i++) {
        formData.append('files[]', files[i]);
    }

    fetch('upload.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function displayFileNames(files) {
    let fileNamesDiv = document.getElementById('file-names'); // Correction ici pour correspondre à l'ID dans le HTML

    for (let i = 0; i < files.length; i++) {
        let fileDiv = document.createElement('div');
        fileDiv.textContent = files[i].name;

        let deleteBtn = document.createElement('span');
        deleteBtn.textContent = '✕';

        (function(fileName) {
            deleteBtn.onclick = function() {
                fileDiv.remove();
                deleteFile(fileName);
            };
        })(files[i].name);

        fileDiv.appendChild(deleteBtn);
        fileNamesDiv.appendChild(fileDiv);
    }
}

function deleteFile(fileName) {
    let formData = new FormData();
    formData.append('file_name', fileName); // Correction pour la cohérence avec le script PHP

    fetch('FileDelete.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
