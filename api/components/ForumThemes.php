<?php
// Démarrage de la session
session_start();

// Inclusion du fichier de configuration de la base de données
require_once('../config/bdd.php');

// Gérer les différentes actions en fonction de la requête
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['theme_id'])) {
        try {
            // Vérifier si l'ID du thème est passé en paramètre
            $themeId = $_GET['theme_id'];

            // Requête pour récupérer les sujets du thème spécifié
            $requete = "SELECT * FROM forum_topic WHERE theme_id = :theme_id";
            $resultat = $cnx->prepare($requete);    
            $resultat->bindParam(':theme_id', $themeId);
            $resultat->execute();

            // Initialisation d'un tableau pour stocker les résultats
            $sujets = [];

            // Récupération des résultats
            while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $sujets[] = $ligne;
            }

            // Conversion du tableau en JSON et affichage
            echo json_encode($sujets);
        } catch (PDOException $e) {
            // En cas d'erreur, renvoie d'un message d'erreur en JSON
            echo json_encode(["error" => "Erreur lors de l'exécution de la requête : " . $e->getMessage()]);
        }
    } else {
        // Si l'ID du thème n'est pas spécifié, récupérer tous les thèmes du forum
        try {
            // Requête pour récupérer tous les thèmes de la table "forum_theme"
            $requete = "SELECT id, nom FROM forum_theme";
            $resultat = $cnx->query($requete);

            // Initialisation d'un tableau pour stocker les résultats
            $themes = [];

            // Vérifier s'il y a des résultats
            if ($resultat->rowCount() > 0) {
                // Récupération des résultats
                while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    // Ajout de chaque thème dans le tableau
                    $themes[] = $ligne;
                }

                echo json_encode($themes);
            } else {
                // Aucun thème trouvé, renvoie d'un message en JSON
                echo json_encode(["message" => "Aucun thème trouvé dans la base de données."]);
            }
        } catch (PDOException $e) {
            // En cas d'erreur, renvoie d'un message d'erreur en JSON
            echo json_encode(["error" => "Erreur lors de l'exécution de la requête : " . $e->getMessage()]);
        }
    }
} 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données JSON de la requête
    $data = json_decode(file_get_contents('php://input'), true);

    // Débogage : Afficher les données reçues dans les logs du serveur
    error_log('Données reçues : ' . print_r($data, true));

    // Vérifie si l'ID du thème est présent dans les données
    if (isset($data['id_theme']) && !empty($data['id_theme'])) {
        // Récupération des données du formulaire pour le sujet
        $titre = htmlspecialchars($data['titre']); // Titre du sujet
        $theme_id = htmlspecialchars($data['id_theme']); // ID du thème associé

        // ID de l'utilisateur à partir de la session
        $id_utilisateur = $_SESSION['id'];

        // Adresse IP de l'utilisateur
        $user_ip = $_SERVER['REMOTE_ADDR'];

        // Date et heure actuelles
        $now = date("Y-m-d H:i:s");

        // Requête d'insertion dans forum_topic
        $ins_topic = $cnx->prepare("INSERT INTO forum_topic (title, user_id, user_ip, theme_id, first_post_date, last_post_date) VALUES (:title, :user_id, :user_ip, :theme_id, :first_post_date, :last_post_date)");
        $ins_topic->bindParam(':title', $titre);
        $ins_topic->bindParam(':user_id', $id_utilisateur);
        $ins_topic->bindParam(':user_ip', $user_ip);
        $ins_topic->bindParam(':theme_id', $theme_id);
        $ins_topic->bindParam(':first_post_date', $now);
        $ins_topic->bindParam(':last_post_date', $now);

        // Débogage : Afficher les valeurs des paramètres de la requête
        echo "Données pour forum_topic :";
        echo "Title: $titre, User ID: $id_utilisateur, Theme ID: $theme_id, User IP: $user_ip, First Post Date: $now, Last Post Date: $now";

        // Exécution de la requête
        if ($ins_topic->execute()) {
            // Succès de l'insertion dans forum_topic
            echo "Insertion réussie dans forum_topic";
        } else {
            // Erreur lors de l'insertion dans forum_topic
            echo "Erreur lors de l'insertion dans forum_topic";
            // Afficher les détails de l'erreur
            var_dump($ins_topic->errorInfo());
        }

        // Récupération de l'ID du sujet nouvellement créé
        $id_sujet = $cnx->lastInsertId();

        // Récupération des données du formulaire pour le premier message
        $message = strip_tags($data['contenu']); // Contenu du message

        // Requête d'insertion dans forum_post
        $ins_post = $cnx->prepare("INSERT INTO forum_post (topic_id, msg, user_id, user_ip, created_at, updated_at, edited_by_id) VALUES (:topic_id, :msg, :user_id, :user_ip, :created_at, :updated_at, :edited_by_id)");
        $ins_post->bindParam(':topic_id', $id_sujet); // Utilise l'ID du sujet nouvellement créé
        $ins_post->bindParam(':msg', $message);
        $ins_post->bindParam(':user_id', $id_utilisateur); // Utilise l'ID de l'utilisateur à partir de la session
        $ins_post->bindParam(':user_ip', $user_ip);
        $ins_post->bindParam(':created_at', $now);
        $ins_post->bindParam(':updated_at', $now);
        $edited_by_id = 0; // Par défaut, aucun utilisateur n'a édité ce message
        $ins_post->bindParam(':edited_by_id', $edited_by_id);

        // Débogage : Afficher les valeurs des paramètres de la requête
        echo "Données pour forum_post :";
        echo "Topic ID: $id_sujet, Message: $contenu, User ID: $id_utilisateur, User IP: $user_ip, Created At: $now, Updated At: $now, Edited By ID: $edited_by_id";

        // Exécution de la requête
        if ($ins_post->execute()) {
            // Succès de l'insertion dans forum_post
            echo "Insertion réussie dans forum_post";
        } else {
            // Erreur lors de l'insertion dans forum_post
            echo "Erreur lors de l'insertion dans forum_post";
            // Afficher les détails de l'erreur
            var_dump($ins_post->errorInfo());
        }
        $last_post = $cnx->lastInsertId();
        // Mise à jour du champ first_post_id dans forum_topic
        $update_topic = $cnx->prepare("UPDATE forum_topic SET first_post_id = :first_post_id WHERE id = :id_sujet");
        $update_topic->bindParam(':first_post_id', $last_post);
        $update_topic->bindParam(':id_sujet', $id_sujet);

        // Exécution de la requête
        if ($update_topic->execute()) {
            // Succès de la mise à jour dans forum_topic
            echo "Mise à jour réussie dans forum_topic";
        } else {
            // Erreur lors de la mise à jour dans forum_topic
            echo "Erreur lors de la mise à jour dans forum_topic";
            // Afficher les détails de l'erreur
            var_dump($update_topic->errorInfo());
        }

        // Préparation de la réponse dans un tableau
        $response = [
            'success' => true,
            'msg' => 'Sujet et premier post créés avec succès'
        ];

        // Envoi de la réponse au format JSON
        echo json_encode($response);
    } else {
        // L'ID du thème n'est pas présent dans les données
        $response = [
            'success' => false,
            'msg' => 'L\'ID du thème n\'est pas présent dans les données'
        ];
        echo json_encode($response);
    }
}




