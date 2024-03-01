<h1>Thèmes du Forum</h1>
<div class="themes-container"></div> 
<div class="sujets-container"></div>

<?php
if (isset($_SESSION['id']) === true) {
    // L'utilisateur est connecté, afficher le formulaire de création de sujet
    ?>
    <form id="createSubjectForm" method="post">
        <label for="titre">Titre</label>
        <input for="text" id="titre" name="titre">
        <input type="submit" value="Créer le sujet">
    </form>
    <?php
} else {
    // L'utilisateur n'est pas connecté, afficher un message de connexion requise
    echo "Vous devez être connecté pour créer un sujet. <a href='?action=login'>Se connecter</a>";
}
?>

<script src="../assets/js/forumThemes.js"></script>
<script src="../assets/js/sujetCreate.js"></script>