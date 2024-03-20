<?php
// Démarrer la session
session_start();

// Initialiser une variable pour stocker la réponse JSON
$response = array();

// Vérifier si l'utilisateur est connecté et si son ID est défini dans la session
if (!isset($_SESSION['user_id'])) {
    // Gérer le cas où l'utilisateur n'est pas connecté
    $response['error'] = true;
    $response['message'] = "Utilisateur non connecté.";
} else {
    // Vérifier si le formulaire a été soumis via la méthode POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si l'ID du sujet est présent dans la requête POST
        if (isset($_POST['sujet_id'])) {
            // Inclure le fichier de configuration de la base de données
            require_once('../api/config/bdd.php');

            try {
                // Récupérer l'ID du sujet à partir de la requête POST
                $id_sujet = $_POST['sujet_id'];

                // Récupérer le contenu du message
                $message = strip_tags($_POST['contenu']); // Contenu du message

                // Récupérer l'ID de l'utilisateur à partir de la session
                $id_utilisateur = $_SESSION['user_id'];

                // Récupérer l'adresse IP de l'utilisateur
                $user_ip = $_SERVER['REMOTE_ADDR'];

                // Récupérer la date et l'heure actuelles
                $now = date('Y-m-d H:i:s');

                // Requête d'insertion dans forum_post
                $ins_post = $cnx->prepare("INSERT INTO forum_post (topic_id, msg, user_id, user_ip, created_at, updated_at, edited_by_id) VALUES (:topic_id, :msg, :user_id, :user_ip, :created_at, :updated_at, :edited_by_id)");
                $ins_post->bindParam(':topic_id', $id_sujet); // Utilise l'ID du sujet passé dans la requête POST
                $ins_post->bindParam(':msg', $message);
                $ins_post->bindParam(':user_id', $id_utilisateur); // Utilise l'ID de l'utilisateur à partir de la session
                $ins_post->bindParam(':user_ip', $user_ip);
                $ins_post->bindParam(':created_at', $now);
                $ins_post->bindParam(':updated_at', $now);
                $edited_by_id = 0; // Par défaut, aucun utilisateur n'a édité ce message
                $ins_post->bindParam(':edited_by_id', $edited_by_id);

                // Exécution de la requête
                if ($ins_post->execute()) {
                    // Succès de l'insertion dans forum_post
                    $response['error'] = false;
                    $response['message'] = "Insertion réussie dans forum_post";
                } else {
                    // Erreur lors de l'insertion dans forum_post
                    $response['error'] = true;
                    $response['message'] = "Erreur lors de l'insertion dans forum_post";
                    // Afficher les détails de l'erreur
                    $response['error_details'] = $ins_post->errorInfo();
                }
            } catch (PDOException $e) {
                // En cas d'erreur, afficher un message d'erreur
                $response['error'] = true;
                $response['message'] = "Erreur lors de l'insertion du post : " . $e->getMessage();
            }
        } else {
            // Si l'ID du sujet n'est pas présent dans la requête POST, afficher un message d'erreur
            $response['error'] = true;
            $response['message'] = "ID du sujet non spécifié dans la requête POST.";
        }
    } else {
        // Si le formulaire n'a pas été soumis via la méthode POST, afficher un message d'erreur
        $response['error'] = true;
        $response['message'] = "Le formulaire doit être soumis via la méthode POST.";
    }
}

// Envoyer la réponse JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
