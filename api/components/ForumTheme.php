<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Requête pour récupérer tous les thèmes de la table "forum_theme"
$requete = "SELECT nom FROM forum_theme";

try {
    // Exécution de la requête avec la connexion PDO existante
    $resultat = $cnx->query($requete);

    // Vérifier s'il y a des résultats
    if ($resultat->rowCount() > 0) {
        // Initialisation du compteur pour compter les thèmes affichés
        $compteur = 0;

        // Affichage des thèmes
        echo "<div class='themes-container'>";
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            // Affichage de chaque thème comme un lien cliquable
            echo "<span><a href='#'>" . $ligne['nom'] . "</a></span>";
            $compteur++;

            // Ajouter un saut de ligne après chaque troisième thème
            if ($compteur % 3 == 0) {
                echo "<br>";
            }
        }
        echo "</div>";
    } else {
        echo "Aucun thème trouvé dans la base de données.";
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
?>
<style>
/* Style pour le conteneur des thèmes */
div.themes-container {
    display: flex;
    flex-wrap: wrap;
}

/* Style pour chaque thème */
div.themes-container span {
    width: calc(33.33% - 20px); /* Environ 33.33% de la largeur du conteneur moins les marges */
    margin: 10px;
    background-color: #f0f0f0;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.6);
}

/* Style pour les liens dans les thèmes */
div.themes-container span a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    text-transform: uppercase;
}
</style>
