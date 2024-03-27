<header id="menu">
    <a href="index.php">Forum 2024</a>
    <nav>
        <a href="?action=users">Utilisateurs</a>
        <a href="?action=topics">Themes</a>
        <?php 
        if (isset($_SESSION['niveau'])&&$_SESSION['niveau']==4) {
            echo '<a href="?action=admin">Administration</a>';
        }
        // si on est loggué, on dit bonjour
        if (isset($_SESSION['pseudo'])) {
            echo' <a href="?action=mp">Messagerie</a>';
            echo '<span>Bonjour <a href="?action=users&type=profil">' . $_SESSION['pseudo'] . '</a>&nbsp;<a href="?action=logout"<big>&#10151;</big></a></span>';
        } else {
            echo '<a href="?action=login">Se connecter</a>';
            echo '<a href="?action=newUsers">Créer un compte</a>';
        }
    ?>
    </nav>
</header>

