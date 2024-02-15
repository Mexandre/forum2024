<?php
if(!isset($_GET['type'])) {
    ?>
    <section id="user">
        <form id="user-create">
            <h2>Créer un utilisateur</h2>
        <label for="pseudo">Pseudo</label><input type="text" name="pseudo" id="pseudo">
            <label for="email">Email</label><input type="text" name="email" id="email">
            <label for="mdp">Mot de passe</label><input type="text" name="mdp" id="mdp">
            <button>Créer l'utilisateur</button>
        </form>
        <form id="user-search">
            <h2>Trouver un utilisateur</h2>
        <input type="text" id="search-input" placeholder="Entrez votre recherche">
        <input type="hidden" name="userId">
        <ul id="search-results"></ul>

        </form>
    </section>
    <h2 id="msg"></h2>
   <?php
}
?>
<script src="../assets/js/users.js"></script>
