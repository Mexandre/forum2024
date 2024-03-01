<?php
// Définit les en-têtes CORS pour autoriser les requêtes depuis n'importe quelle origine
header("Access-Control-Allow-Origin: *");
// Définit les méthodes HTTP autorisées
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");
// Définit les en-têtes autorisés dans la requête
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Récupère la méthode de la requête HTTP
$method = $_SERVER['REQUEST_METHOD'];
// Récupère les données de la requête au format JSON et les décode en un tableau associatif
$data = json_decode(file_get_contents('php://input'), true);

// Inclut le fichier de configuration de la base de données
require_once('../config/bdd.php');

// Gestion des requêtes GET
if ($method == 'GET') {
    // Vérifie si le paramètre 'q' est présent dans la requête GET
    if (isset($_GET['q'])) {
        // Récupère et nettoie la valeur du paramètre 'q' de la requête
        $query = htmlspecialchars($_GET['q']);
        // Prépare et exécute une requête SQL pour sélectionner les utilisateurs dont le pseudo est similaire à la valeur de 'q'
        $stmt = $cnx->prepare("SELECT * FROM utilisateur WHERE pseudo LIKE ?");
        $stmt->execute(["%$query%"]);
        // Récupère tous les résultats de la requête sous forme de tableau associatif
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else if (isset($_GET['getLevels'])) {
        // Prépare et exécute une requête SQL pour sélectionner les identifiants et les niveaux des utilisateurs
        $stmt = $cnx->prepare("SELECT id, niveau FROM utilisateur_niveau");
        $stmt->execute();
        // Récupère tous les résultats de la requête sous forme de tableau associatif
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Retourne une réponse JSON indiquant que le paramètre 'q' est manquant
        echo json_encode(array('error' => 'Le paramètre "q" est manquant'));
    }
}

// Gestion des requêtes POST
if ($method == 'POST') {
    // Récupère et décode les données de la requête au format JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérifie si les données requises pour créer un utilisateur sont présentes
    if (isset($data['pseudo'], $data['email'], $data['mdp'], $data['birth'])) {
        // Nettoie les données et les prépare pour l'insertion dans la base de données
        $pseudo = htmlspecialchars($data['pseudo']);
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $mdp = password_hash($data['mdp'], PASSWORD_DEFAULT);
        $birth = htmlspecialchars($data['birth']);
        
        // Prépare et exécute une requête SQL pour insérer un nouvel utilisateur dans la base de données
        $ins = $cnx->prepare("INSERT INTO utilisateur SET pseudo = :pseudo, mail= :email, pass= :mdp, date_naiss= :birth, date_ins= :date");
        $ins->bindParam(':pseudo', $pseudo); // Lie la variable pseudo à un paramètre dans la requête
        $ins->bindParam(':email', $email); // Lie la variable email à un paramètre dans la requête
        $ins->bindParam(':mdp', $mdp); // Lie la variable mdp à un paramètre dans la requête
        $ins->bindParam(':birth', $birth); // Lie la variable birth à un paramètre dans la requête
        $ins->bindParam(':date', date("Y-m-d H:i:s")); // Lie la date actuelle à un paramètre dans la requête
        $ins->execute(); // Exécute la requête SQL

        // Retourne une réponse JSON indiquant que l'utilisateur a été créé avec succès
        $response = [
            'success' => true,
            'msg' => 'Utilisateur créé avec succès'
        ];
    } elseif (isset($data['sujet'])) {
        // Gestion de la création d'un sujet sur le forum
        $sujet = htmlspecialchars($data['sujet']);
        $theme = htmlspecialchars($data['theme']);
        $userId = $_SESSION['id']; // Utilisateur connecté (supposé)

        // Prépare et exécute une requête SQL pour insérer un nouveau sujet dans le forum
        $ins = $cnx->prepare("INSERT INTO forum_sujet (id_utilisateur, id_theme, titre) VALUES (:userId, :theme, :sujet)");
        $ins->bindParam(':userId', $userId); // Lie la variable userId à un paramètre dans la requête
        $ins->bindParam(':theme', $theme); // Lie la variable theme à un paramètre dans la requête
        $ins->bindParam(':sujet', $sujet); // Lie la variable sujet à un paramètre dans la requête
        $ins->execute(); // Exécute la requête SQL

        // Retourne une réponse JSON indiquant que le sujet a été créé avec succès
        $response = [
            'success' => true,
            'msg' => 'Sujet créé avec succès'
        ];
    } else {
        // Retourne une réponse JSON indiquant que les données nécessaires pour créer un utilisateur, un sujet ou un avertissement sont manquantes
        $response = [
            'success' => false,
            'msg' => 'Données manquantes pour créer un utilisateur, un sujet ou un avertissement'
        ];
    }
}

// Gestion des requêtes PATCH
if ($method == 'PATCH') {
    // Récupère les données de la requête pour mettre à jour un utilisateur
    $pseudo = htmlspecialchars($data['pseudo']);
    $email = filter_var($data['mail'], FILTER_VALIDATE_EMAIL);
    $mdp = password_hash($data['mdp'], PASSWORD_DEFAULT);
    $id = htmlspecialchars($data['id']);
    $rang = htmlspecialchars($data['rang']); // Ajout de la gestion du rang

    // Vérifie s'il y a une demande d'avertissement
    if (isset($data['avertissement'])) {
        // Incrémente la colonne 'avertissement' dans la base de données
        $insAvertissement = $cnx->prepare("UPDATE utilisateur SET avertissement = avertissement + 1 WHERE id = :id");
        $insAvertissement->bindParam(':id', $id);
        $insAvertissement->execute();
    }

    // Prépare et exécute une requête SQL pour mettre à jour un utilisateur dans la base de données
    $ins = $cnx->prepare("UPDATE utilisateur SET pseudo = :pseudo, mail = :email" . ($mdp ? ", pass = :mdp" : "") . ", niveau_id = :rang WHERE id = :id");
    $ins->bindParam(':pseudo', $pseudo); // Lie la variable pseudo à un paramètre dans la requête
    $ins->bindParam(':email', $email); // Lie la variable email à un paramètre dans la requête
    if ($mdp) {
        $ins->bindParam(':mdp', $mdp); // Lie la variable mdp à un paramètre dans la requête si elle est définie
    }
    $ins->bindParam(':id', $id); // Lie la variable id à un paramètre dans la requête
    $ins->bindParam(':rang', $rang); // Lie la variable rang à un paramètre dans la requête
    $ins->execute(); // Exécute la requête SQL

    // Retourne une réponse JSON indiquant que les données ont été mises à jour avec succès
    $response = [
        'success' => true,
        'msg' => 'Données mises à jour avec succès'
    ];
}


// Gestion des requêtes DELETE
if ($method == 'DELETE') {
    // Vérifie si l'identifiant de l'utilisateur à supprimer est présent dans la requête
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        // Retourne une réponse JSON indiquant que l'identifiant de l'utilisateur est manquant dans la requête
        $response = [
            'success' => false,
            'msg' => 'ID utilisateur manquant dans la requête'
        ];
    } else {
        // Récupère et nettoie l'identifiant de l'utilisateur à supprimer
        $userId = htmlspecialchars($_GET['id']);

        // Prépare et exécute une requête SQL pour supprimer un utilisateur de la base de données
        $stmt = $cnx->prepare("DELETE FROM utilisateur WHERE id = :id");
        $stmt->bindParam(':id', $userId); // Lie la variable userId à un paramètre dans la requête
        $stmt->execute(); // Exécute la requête SQL

        // Retourne une réponse JSON indiquant que l'utilisateur a été supprimé avec succès
        $response = [
            'success' => true,
            'msg' => 'Utilisateur supprimé avec succès'
        ];
    }
}

// Définit le type de contenu de la réponse comme JSON
header('Content-type: application/json');
// Convertit la réponse en format JSON et l'affiche
echo json_encode($response);
?>
