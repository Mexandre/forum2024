
<?php
session_start();
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
            echo $_COOKIE['remember_forum_user'];
            echo $_COOKIE['remember_forum_key'];
            break;
            case 'login':
                require_once(API."ForumLoginForm.php");
            break;
            case 'users':
            // page utilisateur
                switch($type) {
                    default:
                        require_once(API."ForumUserForm.php");
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
