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
    if ($method == 'GET') {
        if(isset($_GET['choix'])) {
            $option = $_GET['choix'];
        } else {
            $option = "";
        }
        // Récupérer les thèmes
        if(!$option) {
            $s = $cnx->query("SELECT * FROM forum_theme ORDER BY nom asc")->fetchAll();
            $response = $s;
        }
        // Récupérer les sujets par thèmes
        if($option == "topics") {
            $s = $cnx->prepare("SELECT * FROM forum_topic WHERE theme_id= ? ORDER BY title asc");
            $s->execute([$data['themeId']]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // Récupérer les messages par sujets
        if($option == "posts") {
            $s = $cnx->prepare("SELECT * FROM forum_post WHERE topic_id= ? ORDER BY created_at desc");
            $s->execute([$data['topicId']]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    if ($method == 'POST') {
        // Créer un thème
        // Créer un sujet
        // Créer un message
    }
    if ($method == 'PUT') {
        // Modifier un thème
        // Modifier un sujet
        // Modifier un message
    }
    if ($method == 'PATCH') {
        // Changer un sujet de thème
        // Changer un message de sujet
    }
    if ($method == 'DELETE') {
        // Supprimer un thème
        // Supprimer un sujet
        // Supprimer un message
    }
    echo json_encode($response);
}
?>
