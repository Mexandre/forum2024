<?php
session_start();
require_once('../api/config/bdd.php');
// Si on a une variable POST qui arrive
if($_POST) {
    // On cherche l'utilisateur
    $s = $cnx->prepare("SELECT * FROM utilisateur WHERE mail = ?");
    $s->execute([$_POST['email']]);
    $r = $s->fetch();
    // Si on trouve le mail
    if($r['mail'] == $_POST['email'] ) {
        // On vérifie le mot de passe
        if(password_verify($_POST['mdp'], $r['pass'])) {
            // On installe les variables de session qui ne peuvent fonctionner qu'avec session_start
            $_SESSION['id'] = $r['id'];
            $_SESSION['pseudo'] = $r['pseudo'];
            $_SESSION['email'] = $r['mail'];
            // Si la case rester connecté est active, on crée les cookies pour se reconnecter automatiquement
            if(isset($_POST['remember'])) {
                // Installation du cookie utilisateur
                setcookie("remember_forum_user", $r['pseudo'], time() +(86400*30), "/");
                // Installation du cookie mot de passe
                setcookie("remember_forum_key", $r['pass'], time() +(86400*30), "/");
            }
            // On redirige sur la page index
            header('location:index.php');
        } else {
            echo "ça marche pas";
        }
    } else {
        echo 'adresse mail invalide';
    }
}