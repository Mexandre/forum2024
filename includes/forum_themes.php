<h1>Thèmes du Forum</h1>
<div class="themes-container"></div> 
<div class="sujets-container"></div>

<?php
if (isset($_SESSION['id']) === true) {
    // L'utilisateur est connecté, afficher le formulaire de création de sujet
    ?>
    <script src="../assets/js/sujetFormCreate.js"></script>
    
    <?php
} else {
    // L'utilisateur n'est pas connecté, afficher un message de connexion requise
    echo "Vous devez être connecté pour créer un sujet. <a href='?action=login'>Se connecter</a>";
}
?>
<h2 id="msg"></h2>
<script src="../assets/js/forumThemes.js"></script>
<script src="../assets/js/sujetCreate.js"></script>