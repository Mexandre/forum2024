<?php
if(!isset($_GET['type'])) {  
    ?>
    <section id="user">
        <form id="user-create">
            <h2>Créer un compte</h2>
            <label for="pseudo">Pseudo</label><input type="text" name="pseudo" id="pseudo">
            <label for="email">Email</label><input type="text" name="email" id="email">
            <label for="mdp">Mot de passe</label><input type="text" name="mdp" id="mdp">
            <label for="birth">Date de naissance</label><input type="date" name="birth" id="birth">
            <button>Créer l'utilisateur</button>
        </form>
    </section>
    <h2 id="msg"></h2>
   <?php
}
?>
<script src="../assets/js/userCreate.js"></script>
