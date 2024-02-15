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
        $stmt = $cnx->prepare("SELECT * FROM forum_users WHERE pseudo LIKE ?");
        $stmt->execute(["%$query%"]);
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retournez les résultats au format JSON
      //  echo json_encode($results);
    } else {
        // Si le paramètre 'q' n'est pas présent, vous pouvez renvoyer un message d'erreur ou une réponse vide selon vos besoins.
        echo json_encode(array('error' => 'Le paramètre "q" est manquant'));
    } 
}
if($method == 'POST') {
    
    $ins = $cnx->prepare("INSERT INTO forum_users SET pseudo = :pseudo, email= :email, mdp= :mdp, date_create= :date");
    $ins->bindParam(':pseudo', $data['pseudo']);
    $ins->bindParam(':email', $data['email']);
    $ins->bindParam(':mdp', password_hash($data['mdp'], PASSWORD_DEFAULT));
    $ins->bindParam(':date', date("Y-m-d H:i:s"));
    $ins->execute();
    
    // On prépare la réponse dans un array
    $response = [
        'success' => true,
        'msg' => $data
    ];
}
if($method == 'PATCH') {
   $ins = $cnx->prepare("UPDATE forum_users SET pseudo = :pseudo, email = :email" . ($data['mdp'] ? ", mdp = :mdp" : "") . " WHERE id = :id");
   $ins->bindParam(':pseudo', $data['pseudo']);
   $ins->bindParam(':email', $data['email']);
   if ($data['mdp']) {
       $ins->bindParam(':mdp', password_hash($data['mdp'], PASSWORD_DEFAULT));
   }
   $ins->bindParam(':id', $data['id']);
   $ins->execute();

   // Préparer la réponse dans un tableau
   $response = [
       'success' => true,
       'msg' => 'Données mises à jour avec succès'
   ];
}
if($method == 'DELETE') {
    // Vérifiez s'il y a un ID utilisateur dans la requête
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        // Si l'ID est manquant, renvoyer une erreur
        $response = [
            'success' => false,
            'msg' => 'ID utilisateur manquant dans la requête'
        ];
    } else {
        // Récupérez l'ID de l'utilisateur depuis la requête
        $userId = $_GET['id'];

        // Préparez et exécutez la requête de suppression dans la base de données
        $stmt = $cnx->prepare("DELETE FROM forum_users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        // Préparez la réponse dans un tableau
        $response = [
            'success' => true,
            'msg' => 'Utilisateur supprimé avec succès'
        ];
    }
}
    // On indique qu'on renvoie un json
    header('Content-type:application/json');
    // On transforme l'array en json et on l'affiche en réponse.
    echo json_encode($response);

?>