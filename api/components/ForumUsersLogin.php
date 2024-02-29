<?php
header('Content-Type: application/json'); // Définit le type de contenu attendu en réponse

// Connexion à la base de données
require_once('../api/config/bdd.php');

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

            if (isset($data['remember'])) {
                // Traitement pour "Se souvenir de moi"
            }

            $response = ['success' => true, 'message' => 'Connexion réussie'];
        } else {
            $response['message'] = "Adresse e-mail invalide ou mot de passe incorrect";
        }
    }

    echo json_encode($response);
    exit;
}
?>
