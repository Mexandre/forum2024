<?php
// Assurez-vous que ce script est bien sécurisé par des contrôles d'accès appropriés
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileName = $_POST['file_name']; // Doit correspondre au nom dans FormData
    $filePath = 'uploads/' . $fileName; // Chemin du dossier où les fichiers sont stockés

    if (file_exists($filePath)) {
        unlink($filePath);
        echo "Le fichier $fileName a été supprimé.";
    } else {
        echo "Le fichier $fileName n'existe pas.";
    }
} else {
    echo "Méthode HTTP non autorisée.";
}
?>
