<h1>Posts du Forum</h1>
<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

// // Vérifier si l'ID du sujet est présent dans la requête GET
// if(isset($_GET['sujet_id'])) {
//     // Inclure le fichier de configuration de la base de données
//     require_once('../api/config/bdd.php');

//     try {
//         // Préparer la requête SQL pour récupérer les posts associés au sujet
//         $query = "SELECT p.*, u.username AS auteur 
//                   FROM forum_post p 
//                   LEFT JOIN user u ON p.user_id = u.id
//                   WHERE p.topic_id = :sujet_id";
//         $stmt = $cnx->prepare($query);
//         $stmt->bindParam(':sujet_id', $_GET['sujet_id']);

//         // Exécuter la requête
//         $stmt->execute();

//         // Récupérer les résultats
//         $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         // Afficher les posts
//         foreach($posts as $post) {
//             echo "<div>";
//             echo "<p><strong>Auteur :</strong> {$post['auteur']}</p>";
//             echo "<p><strong>Contenu :</strong> {$post['msg']}</p>";            
//             echo "</div>";
//         }
//     } catch (PDOException $e) {
//         // En cas d'erreur, afficher un message d'erreur
//         echo "Erreur lors de la récupération des posts : " . $e->getMessage();
//     }
// } else {
//     // Si l'ID du sujet n'est pas présent dans la requête GET, afficher un message d'erreur
//     echo "ID du sujet non spécifié.";
// }
?>


<h2>Créer un nouveau post</h2>
<form method="POST">
    <?php
    // Vérifier si l'ID du sujet est présent dans la requête GET avant de l'utiliser
    if(isset($_GET['sujet_id'])) {
        echo '<input type="hidden" name="sujet_id" value="' . $_GET['sujet_id'] . '">';
    } else {
        echo '<input type="hidden" name="sujet_id" value="">';
    }
    ?>
    <label for="contenu">Contenu :</label><br>
    <textarea id="contenu" name="contenu" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Envoyer">
</form>
<script src="../assets/js/ForumCreatePost.js"></script>