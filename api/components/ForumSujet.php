<?php
require_once('../config/bdd.php');

try {
    // Vérifier si l'ID du thème est passé en paramètre
    if (isset($_GET['theme_id'])) {
        $themeId = $_GET['theme_id'];

        // Requête pour récupérer les sujets du thème spécifié
        $requete = "SELECT * FROM forum_topic WHERE theme_id = :theme_id";
        $resultat = $cnx->prepare($requete);    
        $resultat->bindParam(':theme_id', $themeId);
        $resultat->execute();

        // Initialisation d'un tableau pour stocker les résultats
        $sujets = [];

        // Récupération des résultats
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $sujets[] = $ligne;
        }

        // Conversion du tableau en JSON et affichage
        echo json_encode($sujets);
    } else {
        // ID du thème non spécifié, renvoie d'un message en JSON
        echo json_encode(["error" => "ID du thème non spécifié."]);
    }
} catch (PDOException $e) {
    // En cas d'erreur, renvoie d'un message d'erreur en JSON
    echo json_encode(["error" => "Erreur lors de l'exécution de la requête : " . $e->getMessage()]);
}
?>