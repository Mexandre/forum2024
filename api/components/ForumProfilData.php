<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$method = $_SERVER['REQUEST_METHOD'];

require_once('../config/bdd.php'); // Vérifiez le chemin vers votre fichier de configuration de base de données.

if ($method == 'POST') {

        // Récupération des données JSON de la requête
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérification si les données envoyées contiennent les clés nécessaires pour déterminer s'il s'agit d'une demande de création d'utilisateur ou de création de sujet
    if (isset($data['nom'], $data['prenom'], $data['genre'], $data['adresse'], $data['pays'], $data['cp'], $data['ville'])) {

    // Utilisation de htmlspecialchars pour sécuriser les données entrantes
    $nom = htmlspecialchars($data['nom']);
    $prenom = htmlspecialchars($data['prenom']);
    $genre = filter_var($data['genre']);
    $adresse = htmlspecialchars($data['adresse']);
    $pays = htmlspecialchars($data['pays']);
    $cp = filter_var($data['cp'], FILTER_VALIDATE_INT);
    $ville = htmlspecialchars($data['ville']);

    $ins = $cnx->prepare("INSERT INTO profil (nom, prenom, genre, adresse, pays, cp, ville) VALUES (:nom, :prenom, :genre, :adresse, :pays, :cp, :ville)");
    $ins->bindParam(':nom', $data['nom']);
    $ins->bindParam(':prenom', $data['prenom']);
    $ins->bindParam(':genre', $data['genre']);
    $ins->bindParam(':adresse', $data['adresse']);
    $ins->bindParam(':pays', $data["pays"]);
    $ins->bindParam(':cp', $data["cp"]);
    $ins->bindParam(':ville', $data["ville"]);
    $ins->execute();

    $response = [
        'success' => true,
        'msg' => 'Profil créé avec succès.'
    ];
} else {
    $response = [
        'success' => false,
        'msg' => 'Méthode non autorisée.'
    ];
}}

header('Content-type: application/json');
echo json_encode($response);
?>
