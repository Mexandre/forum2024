<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-type: application/json'); 

require_once('../config/bdd.php');

session_start();

$response = ['success' => false, 'msg' => 'Une erreur inattendue s\'est produite'];
$method = $_SERVER['REQUEST_METHOD'];

$data = json_decode(file_get_contents('php://input'), true);

if ($method == 'POST') {
    try {
        // Insérer les données dans la base de données
        $sql = "INSERT INTO forum_mp_subject (msg, owner_id, owner_ip) VALUES (:msg, :owner_id, :owner_ip)";
        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':msg', $data['sujetmp']);
        $stmt->bindValue(':owner_id', $_SESSION['id']); // Utilisez l'ID de l'utilisateur connecté
        $stmt->bindValue(':owner_ip', $_SERVER['REMOTE_ADDR']); // Utilisez l'adresse IP de l'utilisateur
        $stmt->execute();

        // Récupérer l'ID du sujet inséré
        $subjectId = $cnx->lastInsertId();

        // Insérer le message dans la table forum_mp_msg
        $sql = "INSERT INTO forum_mp_msg (mp_id, user_id, sender_id, sender_ip, date_posted, msg, receiver_id) 
                VALUES (:mp_id, :user_id, :sender_id, :sender_ip, NOW(), :msg, :receiver_id)";
        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':mp_id', $subjectId);
        $stmt->bindValue(':sender_id', $_SESSION['id']); // Utilisez l'ID de l'utilisateur connecté comme envoyeur
        $stmt->bindValue(':sender_ip', $_SERVER['REMOTE_ADDR']); // Utilisez l'adresse IP de l'utilisateur
        $stmt->bindParam(':msg', $data['message']);
        $stmt->bindValue(':receiver_id', $data['userId']); // Vous devrez récupérer l'ID du destinataire selon votre logique
        
        $stmt->bindValue(':user_id', $_SESSION['id']); // Utilisez l'ID de l'utilisateur connecté
        $stmt->execute();
        
        $stmt->bindValue(':user_id', $data['userId']); // Utilisez l'ID de l'utilisateur connecté
        $stmt->execute();


        // Répondre avec un message de succès
        $response = [
            'success' => true,
            'msg' => 'Message créé avec succès'
        ];
    } catch (Exception $e) {
        // En cas d'erreur, répondre avec un message d'erreur
        $response = [
            'success' => false,
            'msg' => 'Erreur lors du traitement : ' . $e->getMessage()
        ];
    }

    // Renvoyer la réponse au format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>