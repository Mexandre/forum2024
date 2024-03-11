<?php
// Vérifier si l'ID du sujet est présent dans la requête
if(isset($_GET['sujet_id'])) {
    // Inclure le fichier de configuration de la base de données
    require_once('../config/bdd.php');

    try {
        // Préparer la requête SQL pour récupérer les posts associés au sujet
        $query = "SELECT * FROM posts WHERE sujet_id = :sujet_id";
        $stmt = $cnx->prepare($query);
        $stmt->bindParam(':sujet_id', $_GET['sujet_id']);
        
        // Exécuter la requête
        $stmt->execute();
        
        // Récupérer les résultats
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Retourner les résultats au format JSON
        echo json_encode($posts);
    } catch (PDOException $e) {
        // En cas d'erreur, renvoyer un message d'erreur au format JSON
        echo json_encode(array("error" => "Erreur lors de la récupération des posts : " . $e->getMessage()));
    }
} else {
    // Si l'ID du sujet n'est pas présent dans la requête, renvoyer un message d'erreur au format JSON
    echo json_encode(array("error" => "ID du sujet non spécifié."));
}
?>
