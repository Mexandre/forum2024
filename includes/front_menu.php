<header id="menu">
    <a href="index.php">Forum 2024</a>
    <nav>
        <a href="?action=users">Utilisateurs</a>
        <a href="?action=topics">Sujets</a>
        <a href="?action=admin">Administration</a>
        <a href="?action=mp">Messages Privées</a>
        <?php 
        // si on est loggué, on dit bonjour
        if (isset($_SESSION['pseudo'])) {
            echo "Bonjour " . $_SESSION['pseudo'];
            echo '<a href="?action=logout">&#10151;</a>';
        } else {
            echo '<a href="?action=login">Se connecter</a>';
            echo '<a href="?action=newUsers">Créer un compte</a>';
        }
    ?>

    </nav>
</header>

