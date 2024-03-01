<?php
session_start(); // Démarrer la session s'il n'est pas déjà démarré

// Vérifie si la méthode de la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données JSON de la requête
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérifie si l'ID du thème est présent dans les données
    if (isset($data['id_theme']) && !empty($data['id_theme'])) {
        // Récupération de l'ID du thème
        $id_theme = htmlspecialchars($data['id_theme']);

        // Assurez-vous que l'ID du thème est un nombre entier
        if (ctype_digit($id_theme)) {
            require_once('../config/bdd.php');

            $id_utilisateur = $_SESSION['id'];

            // Utilisation de htmlspecialchars pour sécuriser les données entrantes
            $titre = htmlspecialchars($data['titre']);

            // Utilisation de requêtes préparées pour éviter les injections SQL
            $ins = $cnx->prepare("INSERT INTO forum_sujet SET titre = :titre, id_utilisateur = :id, id_theme = :id_theme");
            $ins->bindParam(':titre', $titre);
            $ins->bindParam(':id_utilisateur', $id_utilisateur);
            $ins->bindParam(':id_theme', $id_theme);
            $ins->execute();

            // Préparation de la réponse dans un tableau
            $response = [
                'success' => true,
                'msg' => 'Sujet créé avec succès'
            ];

            // Envoi de la réponse au format JSON
            echo json_encode($response);
        } else {
            // L'ID du thème n'est pas valide
            $response = [
                'success' => false,
                'msg' => 'L\'ID du thème n\'est pas valide'
            ];
            echo json_encode($response);
        }
    } else {
        // L'ID du thème n'est pas présent dans les données
        $response = [
            'success' => false,
            'msg' => 'L\'ID du thème n\'est pas présent dans les données'
        ];
        echo json_encode($response);
    }
}
?>
