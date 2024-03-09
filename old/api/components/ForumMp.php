<?php
// Démarrer la session si ce n'est pas déjà fait
session_start();

// Vérifier si l'utilisateur est connecté et récupérer son ID
if (!isset($_SESSION['user_id'])) {
    echo "Erreur : Identifiant d'utilisateur non défini dans la session.";
    exit();
}

// Récupération des données du formulaire
$destinataire = $_POST['destinataire'];
$sujet = $_POST['sujetmp']; // Nom du salon
$message = $_POST['message'];

// Récupération de l'ID de l'utilisateur connecté
$sender_id = $_SESSION['user_id'];

// Connexion à la base de données
require_once('../api/config/bdd.php');

// Récupération de l'ID du destinataire
$sql_destinataire = "SELECT id FROM user WHERE username = '$destinataire'";
$result_destinataire = $conn->query($sql_destinataire);

if ($result_destinataire->num_rows > 0) {
    $row = $result_destinataire->fetch_assoc();
    $destinataire_id = $row["id"];
} else {
    echo "Destinataire non trouvé dans la base de données.";
    exit();
}

// Vérifier si le salon existe déjà
$sql_salon = "SELECT id FROM message_room WHERE name = '$sujet'";
$result_salon = $conn->query($sql_salon);

if ($result_salon->num_rows == 0) {
    // Si le salon n'existe pas, l'insérer dans la base de données
    $sql_insert_salon = "INSERT INTO message_room (name, creator_id) VALUES ('$sujet', $sender_id)";
    if ($conn->query($sql_insert_salon) === FALSE) {
        echo "Erreur lors de l'insertion du salon: " . $conn->error;
        exit();
    }
}

// Récupérer l'ID du salon (nouvellement inséré ou déjà existant)
$sql_get_salon_id = "SELECT id FROM message_room WHERE name = '$sujet'";
$result_salon_id = $conn->query($sql_get_salon_id);

if ($result_salon_id->num_rows > 0) {
    $row = $result_salon_id->fetch_assoc();
    $salon_id = $row["id"];
} else {
    echo "Erreur lors de la récupération de l'ID du salon.";
    exit();
}

// Insérer le message dans la table des échanges de messages
$sql_message = "INSERT INTO message_exchange (room_id, msg, sender_id, receiver_id) VALUES ($salon_id, '$message', $sender_id, $destinataire_id)";
if ($conn->query($sql_message) === FALSE) {
    echo "Erreur lors de l'insertion du message: " . $conn->error;
    exit();
}

echo "Message envoyé avec succès.";
?>