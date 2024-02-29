<?php
session_start(); // Démarrage de la session

if (isset($_SESSION['id'])) { // Vérifie si l'utilisateur est connecté
    require_once('../api/config/bdd.php'); // Inclusion du fichier de configuration de la base de données

    $s = $cnx->prepare("SELECT * FROM utilisateur WHERE id = ?"); // Préparation de la requête SQL pour récupérer l'utilisateur par ID
    $s->execute([$_SESSION['id']]); // Exécute la requête avec l'ID de l'utilisateur stocké dans la session
    $r = $s->fetch(); // Récupère la première ligne de résultat

    if ($r && is_array($r) && isset($r['id'])) { // Vérifie si un utilisateur correspondant à l'ID existe
        $_SESSION['id'] = $r['id']; // Stocke l'ID de l'utilisateur dans la session
        $_SESSION['pseudo'] = $r['pseudo']; // Stocke le pseudo de l'utilisateur dans la session
        $_SESSION['email'] = $r['mail']; // Stocke l'adresse e-mail de l'utilisateur dans la session
    }
} elseif (isset($_COOKIE['forum_user_token'])) { // Si l'utilisateur n'est pas connecté mais qu'un cookie contenant le jeton est présent
    require_once('../api/config/bdd.php'); // Inclusion du fichier de configuration de la base de données

    $s = $cnx->prepare("SELECT * FROM utilisateur WHERE jeton = ?"); // Préparation de la requête SQL pour récupérer l'utilisateur par jeton
    $s->execute([$_COOKIE['forum_user_token']]); // Exécute la requête avec le jeton stocké dans le cookie
    $r = $s->fetch(); // Récupère la première ligne de résultat

    if ($r && is_array($r) && isset($r['id'])) { // Vérifie si un utilisateur correspondant au jeton existe
        $_SESSION['id'] = $r['id']; // Stocke l'ID de l'utilisateur dans la session
        $_SESSION['pseudo'] = $r['pseudo']; // Stocke le pseudo de l'utilisateur dans la session
        $_SESSION['email'] = $r['mail']; // Stocke l'adresse e-mail de l'utilisateur dans la session
    }
}

$lang = "fr-FR"; // Définition de la langue par défaut
$title = "Mon forum"; // Titre de la page
$description = "Ceci est une API de gestion de forum"; // Description de la page

define('API', '../api/components/'); // Définition du chemin vers les composants de l'API
define('ROOT', '../'); // Définition du chemin vers la racine du site
require_once(ROOT . "includes/top.php"); // Inclusion du fichier top.php contenant le code HTML de l'en-tête de la page
?>

<link rel="stylesheet" href="<?= ROOT; ?>assets/css/style.css"> <!-- Inclusion du fichier CSS -->

</head>
<body>

<?php
require_once(ROOT . "includes/menu.php"); // Inclusion du fichier menu.php contenant le code HTML du menu de navigation

$action = isset($_GET['action']) ? $_GET['action'] : ""; // Récupération de la valeur de la variable d'action depuis l'URL
$type = isset($_GET['type']) ? $_GET['type'] : ""; // Récupération de la valeur du type depuis l'URL

switch ($action) { // Switch sur la variable d'action
    default:
        // Page par défaut
        // echo $_COOKIE['remember_forum_user'];
        // echo $_COOKIE['remember_forum_key'];
        break;
    case 'login':
        require_once(API . "ForumLoginForm.php"); // Inclusion du formulaire de connexion au forum
        break;
    case 'newusers':
        require_once(API . "ForumUserForm.php"); // Inclusion du formulaire d'inscription de nouveaux utilisateurs
        break;
    case 'topics': 
        require_once(API . "ForumTheme.php");
        break;
    case 'users':
        // page utilisateur
        switch ($type) { // Switch sur le type
            default:
                require_once(API . "ForumUsersFind.php"); // Inclusion de la page de recherche d'utilisateurs
                break;
            case 'edit':
                require_once(API . "ForumUserForm.php"); // Inclusion du formulaire de modification d'utilisateur
                break;
        }
        break;
}

require_once(ROOT . "includes/bottom.php"); // Inclusion du fichier bottom.php contenant le code HTML du pied de page
?>
