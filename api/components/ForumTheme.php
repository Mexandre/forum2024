<?php
// Requête pour récupérer tous les thèmes de la table "forum_theme"
require_once('../api/config/bdd.php');

try {
    // Exécution de la requête avec la connexion PDO existante
    $requete = "SELECT nom FROM forum_theme";
    $resultat = $cnx->query($requete);

    // Vérifier s'il y a des résultats
    if ($resultat->rowCount() > 0) {


        // Affichage des thèmes
        echo "<div class='themes-container'>";
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            // Affichage de chaque thème comme un lien cliquable
            echo "<a href='#'>" . $ligne['nom'] . "</a>";
        }
        echo "</div>";
    } else {
        echo "Aucun thème trouvé dans la base de données.";
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
?>