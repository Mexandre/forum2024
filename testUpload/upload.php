<?php
// upload.php
$targetDir = "uploads/"; // Assurez-vous que ce répertoire existe et est accessible en écriture

foreach ($_FILES['files']['name'] as $key => $name) {
    $targetFilePath = $targetDir . basename($name);

    // Vous pouvez ajouter des vérifications ici (par exemple, sur le type de fichier)

    if(move_uploaded_file($_FILES['files']['tmp_name'][$key], $targetFilePath)){
        echo "Le fichier $name a bien été uploadé.";
    } else{
        echo "Erreur lors de l'upload de $name.";
    }
}
