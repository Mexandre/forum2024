<?php
// Requête pour récupérer tous les thèmes de la table "forum_theme"
require_once('../api/config/bdd.php');

try {
    // Exécution de la requête avec la connexion PDO existante
    $requete = "SELECT id, nom FROM forum_theme";
    $resultat = $cnx->query($requete);

    // Initialisation d'un tableau pour stocker les résultats
    $themes = [];

    // Vérifier s'il y a des résultats
    if ($resultat->rowCount() > 0) {
        // Récupération des résultats
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            // Ajout de chaque thème dans le tableau
            $themes[] = $ligne;
        }

        // Conversion du tableau en JSON et affichage
        echo json_encode($themes);
    } else {
        // Aucun thème trouvé, renvoie d'un message en JSON
        echo json_encode(["message" => "Aucun thème trouvé dans la base de données."]);
    }
} catch (PDOException $e) {
    // En cas d'erreur, renvoie d'un message d'erreur en JSON
    echo json_encode(["error" => "Erreur lors de l'exécution de la requête : " . $e->getMessage()]);
}
?>
