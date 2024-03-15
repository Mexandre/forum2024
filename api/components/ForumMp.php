<?php
require_once('../config/bdd.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    try {
        // Récupérer les données du formulaire
        $destinataire = $_POST['destinataire'];
        $sujetmp = $_POST['sujetmp']; // Sujet du message
        $message = $_POST['message']; // Corps du message

        // Insérer le sujet du message dans la table forum_mp_subject
        $sql = "INSERT INTO forum_mp_subject (msg, owner_id, owner_ip) VALUES (:msg, :owner_id, :owner_ip)";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':msg', $sujetmp);
        $stmt->bindValue(':owner_id', $_SESSION['user_id']); // Utilisez l'ID de l'utilisateur connecté
        $stmt->bindValue(':owner_ip', $_SERVER['REMOTE_ADDR']); // Utilisez l'adresse IP de l'utilisateur
        $stmt->execute();

        // Récupérer l'ID du sujet inséré
        $mpId = $bdd->lastInsertId();

        // Insérer le message dans la table forum_mp_msg
        $sql = "INSERT INTO forum_mp_msg (mp_id, user_id, sender_id, sender_ip, date_posted, msg, receiver_id) 
                VALUES (:mp_id, :user_id, :sender_id, :sender_ip, NOW(), :msg, :receiver_id)";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':mp_id', $mpId); // Utilisez l'ID du sujet inséré
        $stmt->bindValue(':user_id', $_SESSION['user_id']); // Utilisez l'ID de l'utilisateur connecté
        $stmt->bindValue(':sender_id', $_SESSION['user_id']); // Utilisez l'ID de l'utilisateur connecté comme expéditeur
        $stmt->bindValue(':sender_ip', $_SERVER['REMOTE_ADDR']); // Utilisez l'adresse IP de l'utilisateur
        $stmt->bindParam(':msg', $message);
        $stmt->bindValue(':receiver_id', $destinataire); // Vous devrez récupérer l'ID du destinataire selon votre logique

        $stmt->execute();

        // Répondre avec un message de succès
        $response = [
            'success' => true,
            'msg' => 'Message créé avec succès'
        ];
    }  catch (Exception $e) {
        // En cas d'erreur, répondre avec un message d'erreur
        $response = [
            'success' => false,
            'msg' => 'Erreur lors du traitement : ' . $e->getMessage()
        ];
        var_dump($e->getMessage()); // Ajoutez cette ligne pour afficher le message d'erreur
    }
    
    // Renvoyer la réponse au format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>