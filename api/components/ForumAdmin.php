<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-type: application/json'); 
session_start(); // Démarrer la session s'il n'est pas déjà démarré
if($_SESSION['niveau'] > 2) {
    // Initialisation de la réponse
    $response = ['success' => false, 'msg' => 'Une erreur inattendue s\'est produite'];
    require_once('../config/bdd.php');
    $method = $_SERVER['REQUEST_METHOD'];
    
    // // if ($method == 'GET') {
    //     if(isset($_GET['choix'])) {
    //         $option = $_GET['choix'];
    //     } else {
    //         $option = "";
    //     }
    //     // Récupérer les thèmes
    //     if(!$option) {
    //         $s = $cnx->query("SELECT * FROM forum_theme ORDER BY nom asc")->fetchAll();
    //         $response = $s;
    //     }
    //     // Récupérer les sujets par thèmes
    //     if($option == "topics") {
    //         $s = $cnx->prepare("SELECT * FROM forum_topic WHERE theme_id= ? ORDER BY title asc");
    //         $s->execute([htmlspecialchars($data['themeId'])]);
    //         $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     }
    //     // Récupérer les messages par sujets
    //     if($option == "posts") {
    //         $s = $cnx->prepare("SELECT * FROM forum_post WHERE topic_id= ? ORDER BY created_at desc");
    //         $s->execute([htmlspecialchars($data['topicId'])]);
    //         $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     }
    // }
    // if ($method == 'POST') {
        $response = json_decode(file_get_contents("php://input"), true);
    
    //     // Créer un thème
    //     if(isset($data['nom'])) {
    //         // Nettoyer les données d'entrée utilisateur
    //         $themeName = htmlspecialchars($data['nom']);

    //         $stmt = $cnx->prepare("INSERT INTO forum_theme (nom) VALUES (:theme)");
    //         $stmt->bindParam(:theme, $themeName),
    //         $success = $stmt->execute();
    //         if($success) {
    //             $response = ['success' => true, 'msg' => 'Le thème a été créé avec succès'];
    //         } else {
    //             $response = ['success' => false, 'msg' => 'Une erreur est survenue lors de la création du thème'];
    //         }
    //     }
    
        // // Créer un sujet
        // if(isset($data['action']) && $data['action'] === 'create_topic') {
        //     // Nettoyer les données d'entrée utilisateur
        //     $themeId = htmlspecialchars($data['themeId']);
        //     $title = htmlspecialchars($data['title']);

        //     $stmt = $cnx->prepare("INSERT INTO forum_topic (theme_id, title) VALUES (?, ?)");
        //     $success = $stmt->execute([$themeId, $title]);
        //     if($success) {
        //         $response = ['success' => true, 'msg' => 'Le sujet a été créé avec succès'];
        //     } else {
        //         $response = ['success' => false, 'msg' => 'Une erreur est survenue lors de la création du sujet'];
        //     }
        // }
    
        // // Créer un message
        // if(isset($data['action']) && $data['action'] === 'create_post') {
        //     // Nettoyer les données d'entrée utilisateur
        //     $topicId = htmlspecialchars($data['topicId']);
        //     $message = htmlspecialchars($data['message']);
        //     $userId = $_SESSION['user_id']; // Assurez-vous que vous avez une variable de session pour l'identifiant de l'utilisateur
        //     $stmt = $cnx->prepare("INSERT INTO forum_post (topic_id, message, user_id) VALUES (?, ?, ?)");
        //     $success = $stmt->execute([$topicId, $message, $userId]);
        //     if($success) {
        //         $response = ['success' => true, 'msg' => 'Le message a été créé avec succès'];
        //     } else {
        //         $response = ['success' => false, 'msg' => 'Une erreur est survenue lors de la création du message'];
        //     }
        // }
    //}
    // if ($method == 'PUT') {
    //     $data = json_decode(file_get_contents("php://input"), true);
    
    //     // Modifier un thème
    //     if(isset($data['action']) && $data['action'] === 'update_theme') {
    //         // Nettoyer les données d'entrée utilisateur
    //         $themeId = htmlspecialchars($data['themeId']);
    //         $newThemeName = htmlspecialchars($data['newThemeName']);

    //         $stmt = $cnx->prepare("UPDATE forum_theme SET nom = ? WHERE id = ?");
    //         $success = $stmt->execute([$newThemeName, $themeId]);
    //         if($success) {
    //             $response = ['success' => true, 'msg' => 'Le thème a été modifié avec succès'];
    //         } else {
    //             $response = ['success' => false, 'msg' => 'Une erreur est survenue lors de la modification du thème'];
    //         }
    //     }
    
    //     // Modifier un sujet
    //     if(isset($data['action']) && $data['action'] === 'update_topic') {
    //         // Nettoyer les données d'entrée utilisateur
    //         $topicId = htmlspecialchars($data['topicId']);
    //         $newTitle = htmlspecialchars($data['newTitle']);

    //         $stmt = $cnx->prepare("UPDATE forum_topic SET title = ? WHERE id = ?");
    //         $success = $stmt->execute([$newTitle, $topicId]);
    //         if($success) {
    //             $response = ['success' => true, 'msg' => 'Le sujet a été modifié avec succès'];
    //         } else {
    //             $response = ['success' => false, 'msg' => 'Une erreur est survenue lors de la modification du sujet'];
    //         }
    //     }
    
    //     // Modifier un message
    //     if(isset($data['action']) && $data['action'] === 'update_post') {
    //         // Nettoyer les données d'entrée utilisateur
    //         $postId = htmlspecialchars($data['postId']);
    //         $newMessage = htmlspecialchars($data['newMessage']);

    //         $stmt = $cnx->prepare("UPDATE forum_post SET message = ? WHERE id = ?");
    //         $success = $stmt->execute([$newMessage, $postId]);
    //         if($success) {
    //             $response = ['success' => true, 'msg' => 'Le message a été modifié avec succès'];
    //         } else {
    //             $response = ['success' => false, 'msg' => 'Une erreur est survenue lors de la modification du message'];
    //         }
    //     }
    // }
    // if ($method == 'PATCH') {
    //     $data = json_decode(file_get_contents("php://input"), true);
    
    //     // Changer un sujet de thème
    //     if(isset($data['action']) && $data['action'] === 'change_topic_theme') {
    //         // Nettoyer les données d'entrée utilisateur
    //         $topicId = htmlspecialchars($data['topicId']);
    //         $newThemeId = htmlspecialchars($data['newThemeId']);

    //         $stmt = $cnx->prepare("UPDATE forum_topic SET theme_id = ? WHERE id = ?");
    //         $success = $stmt->execute([$newThemeId, $topicId]);
    //         if($success) {
    //             $response = ['success' => true, 'msg' => 'Le sujet a été déplacé vers un autre thème avec succès'];
    //         } else {
    //             $response = ['success' => false, 'msg' => 'Une erreur est survenue lors du déplacement du sujet vers un autre thème'];
    //         }
    //     }
    
    //     // Changer un message de sujet
    //     if(isset($data['action']) && $data['action'] === 'change_post_topic') {
    //         // Nettoyer les données d'entrée utilisateur
    //         $postId = htmlspecialchars($data['postId']);
    //         $newTopicId = htmlspecialchars($data['newTopicId']);

    //         $stmt = $cnx->prepare("UPDATE forum_post SET topic_id = ? WHERE id = ?");
    //         $success = $stmt->execute([$newTopicId, $postId]);
    //         if($success) {
    //             $response = ['success' => true, 'msg' => 'Le message a été déplacé vers un autre sujet avec succès'];
    //         } else {
    //             $response = ['success' => false, 'msg' => 'Une erreur est survenue lors du déplacement du message vers un autre sujet'];
    //         }
    //     }
    // }
    
    // if ($method == 'DELETE') {
    //     $data = json_decode(file_get_contents("php://input"), true);
    
    //     // Supprimer un thème
    //     if(isset($data['action']) && $data['action'] === 'delete_theme') {
    //         // Nettoyer les données d'entrée utilisateur
    //         $themeId = htmlspecialchars($data['themeId']);

    //         $stmt = $cnx->prepare("DELETE FROM forum_theme WHERE id = ?");
    //         $success = $stmt->execute([$themeId]);
    //         if($success) {
    //             $response = ['success' => true, 'msg' => 'Le thème a été supprimé avec succès'];
    //         } else {
    //             $response = ['success' => false, 'msg' => 'Une erreur est survenue lors de la suppression du thème'];
    //         }
    //     }
    
    //     // Supprimer un sujet
    //     if(isset($data['action']) && $data['action'] === 'delete_topic') {
    //         // Nettoyer les données d'entrée utilisateur
    //         $topicId = htmlspecialchars($data['topicId']);

    //         $stmt = $cnx->prepare("DELETE FROM forum_topic WHERE id = ?");
    //         $success = $stmt->execute([$topicId]);
    //         if($success) {
    //             $response = ['success' => true, 'msg' => 'Le sujet a été supprimé avec succès'];
    //         } else {
    //             $response = ['success' => false, 'msg' => 'Une erreur est survenue lors de la suppression du sujet'];
    //         }
    //     }
    
    //     // Supprimer un message
    //     if(isset($data['action']) && $data['action'] === 'delete_post') {
    //         // Nettoyer les données d'entrée utilisateur
    //         $postId = htmlspecialchars($data['postId']);

    //         $stmt = $cnx->prepare("DELETE FROM forum_post WHERE id = ?");
    //         $success = $stmt->execute([$postId]);
    //         if($success) {
    //             $response = ['success' => true, 'msg' => 'Le message a été supprimé avec succès'];
    //         } else {
    //             $response = ['success' => false, 'msg' => 'Une erreur est survenue lors de la suppression du message'];
    //         }
    //     }
    // }
    $pouet = ['Bonjour', 'au revoir'];
    echo json_encode($pouet);
}
?>