<?php
// Démarrage de la session
session_start();

// Inclusion du fichier de configuration de la base de données
require_once('../config/bdd.php');

// Vérifier si l'ID du sujet est spécifié dans les paramètres de l'URL
if (isset($_GET['sujet_id'])) {
    try {
        // Récupérer l'ID du sujet depuis les paramètres de l'URL
        $sujetId = $_GET['sujet_id'];

        // Requête pour récupérer les messages du sujet spécifié
        $requete = "SELECT * FROM forum_post WHERE topic_id = :sujet_id";
        $resultat = $cnx->prepare($requete);
        $resultat->bindParam(':sujet_id', $sujetId);
        $resultat->execute();

        // Vérifier s'il y a des messages pour ce sujet
        if ($resultat->rowCount() > 0) {
            // Initialisation d'un tableau pour stocker les messages
            $messages = [];

            // Récupération des messages
            while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $messages[] = $ligne;
            }

            // Afficher les messages au format JSON
            echo json_encode($messages);
        } else {
            // Aucun message trouvé pour ce sujet
            echo json_encode(["message" => "Aucun message trouvé pour ce sujet."]);
        }
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur
        echo json_encode(["error" => "Erreur lors de la récupération des messages : " . $e->getMessage()]);
    }
} else {
    // ID du sujet non spécifié dans les paramètres de l'URL
    echo json_encode(["error" => "ID du sujet non spécifié."]);
}
?>
