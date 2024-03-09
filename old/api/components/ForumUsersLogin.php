<?php
header('Content-Type: application/json'); // Définit le type de contenu attendu en réponse

// Connexion à la base de données
require_once('../config/bdd.php');

$response = ['success' => false, 'message' => 'Une erreur est survenue'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lecture des données JSON postées
    $data = json_decode(file_get_contents('php://input'), true);

    $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    $password = $data['mdp'];

    if (!$cnx) {
        $response['message'] = "Erreur de connexion à la base de données";
    } else {
        $s = $cnx->prepare("SELECT * FROM utilisateur WHERE mail = ?");
        $s->execute([$email]);
        $r = $s->fetch();

        if ($r && password_verify($password, $r['pass'])) {
            // Démarrage de la session et stockage des données
            session_start();
            $_SESSION['id'] = $r['id'];
            $_SESSION['pseudo'] = $r['pseudo'];
            $_SESSION['email'] = $r['mail'];
            $_SESSION['niveau'] = $r['niveau_id'];

            if (isset($data['remember'])) {
                $token = password_hash(random_bytes(32), PASSWORD_DEFAULT); // Génération d'un jeton aléatoire pour se souvenir de l'utilisateur

                $ins = $cnx->prepare("UPDATE utilisateur SET jeton = ? WHERE id = ?"); // Préparation de la requête SQL pour mettre à jour le jeton dans la base de données
                $ins->execute([$token, $_SESSION['id']]); // Exécution de la requête de mise à jour du jeton

                // Création d'un cookie avec le jeton et définition de sa durée de validité (par exemple, un mois)
                setcookie('forum_user_token', $token, time() + (60 * 60 * 24 * 30), "/");            }

            $response = ['success' => true, 'message' => 'Connexion réussie'];
        } else {
            $response['message'] = "Adresse e-mail invalide ou mot de passe incorrect";
        }
    }

    echo json_encode($response);
    exit;
}
?>
