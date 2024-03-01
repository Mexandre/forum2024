<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// On récupère la méthode d'envoie du json (GET/POST/PUT/PATCH/DELETE)
$method = $_SERVER['REQUEST_METHOD'];
// On réception le json et on le transforme en Array
$data = json_decode(file_get_contents('php://input'), true);
// Connexion à la BDD
require_once('../config/bdd.php');
if ($method == 'GET') {
    if (isset($_GET['q'])) {
        // Récupérez la valeur du paramètre 'q' et nettoyez-la pour éviter les injections SQL
        $query = htmlspecialchars($_GET['q']);

        // Effectuez votre recherche dans la base de données
        $stmt = $cnx->prepare("SELECT * FROM utilisateur WHERE pseudo LIKE ?");
        $stmt->execute(["%$query%"]);
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retournez les résultats au format JSON
      //  echo json_encode($results);
    } else {
        // Si le paramètre 'q' n'est pas présent, vous pouvez renvoyer un message d'erreur ou une réponse vide selon vos besoins.
        echo json_encode(array('error' => 'Le paramètre "q" est manquant'));
    } 
}
if ($method == 'POST') {
    // Récupération des données JSON de la requête
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérification si les données envoyées contiennent les clés nécessaires pour déterminer s'il s'agit d'une demande de création d'utilisateur ou de création de sujet
    if (isset($data['pseudo'], $data['email'], $data['mdp'], $data['birth'])) {
        // Connexion à la base de données
        require_once('../config/bdd.php');

        // Utilisation de htmlspecialchars pour sécuriser les données entrantes
        $pseudo = htmlspecialchars($data['pseudo']);
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $mdp = password_hash($data['mdp'], PASSWORD_DEFAULT);
        $birth = htmlspecialchars($data['birth']);
        
        // Utilisation de requêtes préparées pour éviter les injections SQL
        $ins = $cnx->prepare("INSERT INTO utilisateur SET pseudo = :pseudo, mail= :email, pass= :mdp, date_naiss= :birth, date_ins= :date");
        $ins->bindParam(':pseudo', $pseudo);
        $ins->bindParam(':email', $email);
        $ins->bindParam(':mdp', $mdp);
        $ins->bindParam(':birth', $birth);
        $ins->bindParam(':date', date("Y-m-d H:i:s"));
        $ins->execute();

        // Préparation de la réponse dans un tableau
        $response = [
            'success' => true,
            'msg' => 'Utilisateur créé avec succès'
        ];
    } elseif (isset($data['sujet'])) {
        // Connexion à la base de données
        require_once('../config/bdd.php');

        // Utilisation de htmlspecialchars pour sécuriser les données entrantes
        $sujet = htmlspecialchars($data['sujet']);
        $theme = htmlspecialchars($data['theme']);
        $userId = $_SESSION['id'];
    
        // Utilisation de requêtes préparées pour éviter les injections SQL
        $ins = $cnx->prepare("INSERT INTO forum_sujet (id_utilisateur, id_theme, titre) VALUES (:userId, :theme, :sujet)");
        $ins->bindParam(':userId', $userId);
        $ins->bindParam(':theme', $theme);
        $ins->bindParam(':sujet', $sujet);
        $ins->execute();
    
        // Préparation de la réponse dans un tableau
        $response = [
            'success' => true,
            'msg' => 'Sujet créé avec succès'
        ];
    } else {
        // Si les clés nécessaires ne sont pas présentes dans les données envoyées, renvoyer une erreur
        $response = [
            'success' => false,
            'msg' => 'Données manquantes pour créer un utilisateur ou un sujet' . $e->getMessage()
        ];
    }
}
if ($method == 'PATCH') {
    // Utilisez htmlspecialchars pour sécuriser les données entrantes
    $pseudo = htmlspecialchars($data['pseudo']);
    $email = filter_var($data['mail'], FILTER_VALIDATE_EMAIL);
    $mdp = password_hash($data['mdp'], PASSWORD_DEFAULT);
    $id = htmlspecialchars($data['id']);

    // Utilisez des requêtes préparées pour éviter les injections SQL
    $ins = $cnx->prepare("UPDATE utilisateur SET pseudo = :pseudo, mail = :email" . ($mdp ? ", pass = :mdp" : "") . " WHERE id = :id");
    $ins->bindParam(':pseudo', $pseudo);
    $ins->bindParam(':email', $email);
    if ($mdp) {
        $ins->bindParam(':mdp', $mdp);
    }
    $ins->bindParam(':id', $id);
    $ins->execute();

    // Préparer la réponse dans un tableau
    $response = [
        'success' => true,
        'msg' => 'Données mises à jour avec succès'
    ];
}
if ($method == 'DELETE') {
    // Vérifiez s'il y a un ID utilisateur dans la requête
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        // Si l'ID est manquant, renvoyer une erreur
        $response = [
            'success' => false,
            'msg' => 'ID utilisateur manquant dans la requête'
        ];
    } else {
        // Récupérez l'ID de l'utilisateur depuis la requête
        $userId = htmlspecialchars($_GET['id']);

        // Préparez et exécutez la requête de suppression dans la base de données
        $stmt = $cnx->prepare("DELETE FROM utilisateur WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        // Préparez la réponse dans un tableau
        $response = [
            'success' => true,
            'msg' => 'Utilisateur supprimé avec succès'
        ];
    }
}
// On indique qu'on renvoie un JSON
header('Content-type: application/json');
// On transforme l'array en JSON et on l'affiche en réponse.
echo json_encode($response);
?>