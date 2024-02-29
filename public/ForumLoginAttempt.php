<?php
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Récupération et validation de l'adresse e-mail envoyée via POST

require_once('../api/config/bdd.php'); // Inclusion du fichier de configuration de la base de données

if ($_POST) { // Vérification si des données ont été envoyées via POST

    if (!$cnx) { // Vérification de la connexion à la base de données
        die("Erreur de connexion à la base de données");
    }

    $s = $cnx->prepare("SELECT * FROM utilisateur WHERE mail = ?"); // Préparation de la requête SQL pour récupérer l'utilisateur correspondant à l'adresse e-mail
    $s->execute([$email]); // Exécution de la requête avec l'adresse e-mail fournie
    $r = $s->fetch(); // Récupération de la première ligne de résultat

    if (!$r) { // Vérification si aucun utilisateur n'a été trouvé avec cette adresse e-mail
        die("Adresse e-mail invalide ou mot de passe incorrect");
    }

    if ($r['mail'] == $email) { // Vérification si l'adresse e-mail récupérée correspond à celle de l'utilisateur trouvé dans la base de données

        if (password_verify($_POST['mdp'], $r['pass'])) { // Vérification du mot de passe en utilisant la fonction password_verify() avec le hash stocké dans la base de données
            session_start(); // Démarrage de la session

            $_SESSION['id'] = $r['id']; // Stockage de l'ID de l'utilisateur dans la session
            $_SESSION['pseudo'] = $r['pseudo']; // Stockage du pseudo de l'utilisateur dans la session
            $_SESSION['email'] = $r['mail']; // Stockage de l'adresse e-mail de l'utilisateur dans la session

            if (isset($_POST['remember'])) { // Vérification si l'utilisateur a coché l'option "Se souvenir de moi"
                $token = password_hash(random_bytes(32), PASSWORD_DEFAULT); // Génération d'un jeton aléatoire pour se souvenir de l'utilisateur

                $ins = $cnx->prepare("UPDATE utilisateur SET jeton = ? WHERE id = ?"); // Préparation de la requête SQL pour mettre à jour le jeton dans la base de données
                $ins->execute([$token, $_SESSION['id']]); // Exécution de la requête de mise à jour du jeton

                // Création d'un cookie avec le jeton et définition de sa durée de validité (par exemple, un mois)
                setcookie('forum_user_token', $token, time() + (60 * 60 * 24 * 30), "/");
            }

            header('location:index.php'); // Redirection vers la page d'accueil après une connexion réussie
            exit; // Arrêt du script
        } else {
            echo "Mot de passe incorrect"; // Affichage d'un message en cas de mot de passe incorrect
        }
    } else {
        echo 'Adresse e-mail invalide'; // Affichage d'un message en cas d'adresse e-mail invalide
    }
}
?>
