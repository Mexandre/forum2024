
<?php
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
        require_once(ROOT."includes/menu.php");
        $action = isset($_GET['action']) ? $_GET['action'] : "";
        $type = isset($_GET['type']) ? $_GET['type'] : "";
        switch ($action) {
            default:
            // Page par défaut
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
        require_once(ROOT."includes/bottom.php");
    ?>
