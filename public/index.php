
<?php
session_start();
// if(isset($_COOKIE['remember_forum_user'])) {
//     require_once('../api/config/bdd.php');
//     // On cherche l'utilisateur
//     $s = $cnx->prepare("SELECT * FROM utilisateur WHERE pseudo = ? AND pass=? ");
//     $s->execute([$_COOKIE['remember_forum_user'], $_COOKIE['remember_forum_key']]);
//     $r = $s->fetch();
//     $_SESSION['id'] = $r['id'];
//     $_SESSION['pseudo'] = $r['pseudo'];
//     $_SESSION['email'] = $r['mail'];
// }    
if(isset($_COOKIE['forum_user_token'])) {
    require_once('../api/config/bdd.php');
    // On cherche l'utilisateur
    $s = $cnx->prepare("SELECT * FROM utilisateur WHERE jeton = ?");
    $s->execute([$_COOKIE['forum_user_token']]);
    $r = $s->fetch();
    $_SESSION['id'] = $r['id'];
    $_SESSION['pseudo'] = $r['pseudo'];
    $_SESSION['email'] = $r['mail'];
}    

// On définit le contenu à afficher dans les meta données
    $lang= "fr-FR";
    $title = "Mon forum";
    $desription = "Ceci et une api de gestion de forum";
    // On définit les constantes à utiliser
    define('API', '../api/components/');
    define('ROOT', '../');
    require_once(ROOT."includes/top.php");
?>
<link rel="stylesheet" href="<?= ROOT;?>assets/css/style.css">
</head>
<body>
<?php
//    if(isset($_SESSION['id'])) {
        require_once(ROOT."includes/menu.php");
        $action = isset($_GET['action']) ? $_GET['action'] : "";
        $type = isset($_GET['type']) ? $_GET['type'] : "";
        switch ($action) {
            default:
            // Page par défaut
            // echo $_COOKIE['remember_forum_user'];
            // echo $_COOKIE['remember_forum_key'];
            break;
            case 'login':
                require_once(API."ForumLoginForm.php");
            break;
            case 'users':
            // page utilisateur
                switch($type) {
                    default:
                        require_once(API."ForumUsersFind.php");
                    break;
                    case 'edit':
                        require_once(API."ForumUserForm.php");
                    break;
                }
            break;
        }
            
    // } else {
    //     require_once(API."ForumLoginForm.php");
    // }

        require_once(ROOT."includes/bottom.php");
    ?>
