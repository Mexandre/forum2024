<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['id']) && isset($_COOKIE['forum_user_token'])) {
    require_once('../api/config/bdd.php');

    $s = $cnx->prepare("SELECT * FROM user WHERE token = ?");
    $s->execute([$_COOKIE['forum_user_token']]);
    $r = $s->fetch();

    if ($r && is_array($r) && isset($r['id'])) {
        $_SESSION['id'] = $r['id'];
        $_SESSION['username'] = $r['username'];
        $_SESSION['email'] = $r['email'];
    }
}

$lang = "fr-FR"; // Définition de la langue par défaut
$title = "Mon forum"; // Titre de la page
$description = "Ceci est une API de gestion de forum"; // Description de la page

define('API', '../api/components/'); // Définition du chemin vers les composants de l'API
define('INC', '../includes/'); // Définition du chemin vers les composants de l'API
define('ROOT', '../'); // Définition du chemin vers la racine du site
require_once(INC . "front_top.php"); // Inclusion du fichier top.php contenant le code HTML de l'en-tête de la page
?>

<link rel="stylesheet" href="<?= ROOT; ?>assets/css/style.css"> <!-- Inclusion du fichier CSS -->

</head>
<body>

<?php
require_once(INC . "front_menu.php"); // Inclusion du fichier menu.php contenant le code HTML du menu de navigation

$action = isset($_GET['action']) ? $_GET['action'] : ""; // Récupération de la valeur de la variable d'action depuis l'URL
$type = isset($_GET['type']) ? $_GET['type'] : ""; // Récupération de la valeur du type depuis l'URL

switch ($action) { // Switch sur la variable d'action
    default:
        // Page par défaut
        break;
    case 'login':
        require_once(INC . "forum_user_form_login.php"); // Inclusion du formulaire de connexion au forum
        break;
    case 'logout':
        require_once(API . "ForumUsersLogout.php"); // Inclusion du formulaire de connexion au forum
        break;
    case 'newUsers':
        require_once(INC . "forum_user_form_create.php"); // Inclusion du formulaire d'inscription de nouveaux utilisateurs
        break;
    case 'topics': 
        require_once(INC . "forum_themes.php");
        break;
    case 'mp': 
        require_once(INC . "forum_mp.php");
        break;
    case 'users':
        // page utilisateur
        switch ($type) { // Switch sur le type
            default:
                require_once(INC . "forum_user_form_find.php"); // Inclusion de la page de recherche d'utilisateurs
                break;
                case 'edit':
                    require_once(INC . "forum_user_form_edit.php"); // Inclusion du formulaire de modification d'utilisateur
                    break;
            }
        break;
}



require_once(INC . "front_bottom.php"); // Inclusion du fichier bottom.php contenant le code HTML du pied de page
?>
